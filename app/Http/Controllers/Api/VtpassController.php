<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VTpassServices;
use App\Models\VtpassServiceIdentifiers;
use App\Models\TransactionCharges;
use App\Models\VtpassTransactions;
use App\Models\Activities;
use App\Models\User;
use App\Models\EducationCharges;
use App\Models\AdminEarnings;
use App\Models\Admin;
use App\Models\ElectricityTokens;
use Illuminate\Support\Facades\Mail;

class VtpassController extends Controller
{
    public $api_key = "";
    public $sandbox_url = "https://vtpass.com/api/";
    //public $sandbox_url = "https://sandbox.vtpass.com/api/";
    public $username = "dropify2018@gmail.com";
    public $password = "Prinbhobhoangel24#";



      public function makeGetRequest($url){
      $username = $this->username;
      $password = $this->password;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      $result = curl_exec($ch);
      curl_close($ch);  
      return json_decode($result,true);

    }
    

    public function makePostRequest($endpoint,$params){
      $username = $this->username;
      $password = $this->password;

          $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL,$endpoint);
          curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($params));
          curl_setopt($ch, CURLOPT_POST,1);
          curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
          curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response,true);
      }


      public function userDetails(){
        $user_details = User::find(auth()->user()->id);
        return $user_details;
      }



      
    //method to get admin api balance
     public function getBalance(){
     $url = $this->sandbox_url . "balance";
     $balance_details = $this->makeGetRequest($url);
     $wallet_balance = $balance_details["contents"]["balance"];
     dd($wallet_balance);

     }



     //getting the services rendered by vt pass(Admin)
    public function getServices(){
      $url = $this->sandbox_url . "service-categories";

      $services_details = $this->makeGetRequest($url);
      $services = $services_details["content"];
       
      $get_services = VTpassServices::get();
      if($get_services){
        foreach($get_services as $service){
          VTpassServices::find($service->id)->delete();
        }

        foreach($services as $vtpass_service){
          $identifier = $vtpass_service["identifier"];
          $name = $vtpass_service["name"];
          $new_service = new VTpassServices();
          $new_service->identifier = $identifier;
          $new_service->name = $name;
          $new_service->save();
        }
      }else{
        foreach($services as $vtpass_service){
          $identifier = $vtpass_service["identifier"];
          $name = $vtpass_service["name"];
          $new_service = new VTpassServices();
          $new_service->identifier = $identifier;
          $new_service->name = $name;
          $new_service->save();
        }
      }

      return response()->json([
        "message"=> "vtpass services update"
      ]);

    }




    public function fetchVtPassServices(){
       $vtpass_services = VTpassServices::orderBy("id","desc")->get();
      
       
       return response()->json([
         "services" => $vtpass_services
       ]);

      
    }




    //method to update vtpass identifiers(Admin);
    public function vtpassService($identifier){
      $url = $this->sandbox_url . "services?identifier=$identifier";
      $services_details = $this->makeGetRequest($url);
      
      
      $services = $services_details["content"];

      foreach($services as $service){
        $service_identifier = new VtpassServiceIdentifiers();
        $service_identifier->identifier = $identifier;
        $service_identifier->service_id = $service["serviceID"];
        $service_identifier->name = $service["name"];
        $service_identifier->minimum_amount = $service["minimium_amount"];
        $service_identifier->maximum_amount = $service["maximum_amount"];
        $service_identifier->product_type = $service["product_type"];
        $service_identifier->image = $service["image"];
        $service_identifier->save();
     }

     dd("done");
     
      /*
       return response()->json([
         "services" => $services
       ]);*/

      return view("test.service")->with("services",$services);

    }



/*
    public function btcPrice(){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"https://api.coinbase.com/v2/exchange-rates?currency=BTC");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      $result = curl_exec($ch);
      curl_close($ch);  
      $response= json_decode($result,true);
      $data = $response["data"];
      $usd = $data["rates"]["USD"]; 

    }*/

   
    // 1. AIRTIME
   public function vtpassAirtime(){
      $vtpass_airtime_services = VtpassServiceIdentifiers::where("identifier","=","airtime")->get();
      return response()->json([
        "status" => true,
        "airtime_services" => $vtpass_airtime_services
      ]);

    }



    public function confirmVtpassAirtime(Request $request){
      $request->validate([
        "mobile_number" => "required",
        "amount" => "required",
        "network" => "required",         
      ]);
     $user_details = User::find(auth()->user()->id);
     $wallet_balance = $user_details->wallet;
     if($wallet_balance < $request->amount){
         return response()->json([
             "status" => false,
             "message" => "insufficient wallet balance"
             ]);
     
     }else{

     $airtime_details = VtpassServiceIdentifiers::where("service_id","=",$request->network)->first();
     return response()->json([
         "status" => true,
         "airtime_details" => $airtime_details,
         "amount" => $request->amount,
         "mobile_number" => $request->mobile_number
         
         ]);
    }
    }



    public function vtpassAirtimeRecharge(Request $request){
      $date = date("Y-m-d H:i:s");
      //return $date;
      $time_seconds = strtotime($date) + 3600;
     
       $current_time = date("YmdHi",$time_seconds);
       
       $request_id = $current_time."michael";
    
      $params = [
        "request_id" => $request_id,
        "serviceID" => $request->serviceID,
        "amount" => $request->amount,
        "phone" => $request->mobile_number,
      ];

      $url = $this->sandbox_url."pay";

      $response = $this->makePostRequest($url,$params);
      
     
        $transaction_status = $response["response_description"];

        if($transaction_status == "TRANSACTION SUCCESSFUL"){
          $transaction_request_id = $response["requestId"];
          $amount = $response["amount"];

          $transaction_details = $response["content"]["transactions"];
          $product_name = $transaction_details["product_name"];
          $unique_equivalent = $transaction_details["unique_element"];
          $amount_charged = $transaction_details["total_amount"];
          $transaction_id = $transaction_details["transactionId"];
          $commision = $transaction_details["commission"];
          
          
            

          //getting the transaction charge for this transaction
            $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=","end user")->first();
            $user_commision = ($transaction_charge->charge/100) * $commision;
            $admin_share = $commision - $user_commision;
            $user_charge = $amount_charged + $admin_share;
            
            
        
        
          

            //inserting into the vtpass transaction table
            $new_transaction = new VtpassTransactions();
            $new_transaction->user_id = auth()->user()->id;
            $new_transaction->transaction_type = "airtime";
            $new_transaction->product_name = $product_name;
            $new_transaction->unique_equivalent = $unique_equivalent;
            $new_transaction->amount = $amount;
            $new_transaction->amount_charged = $amount_charged;
            $new_transaction->user_charge = $user_charge;
            $new_transaction->admin_share = 0.00;
            $new_transaction->status = $transaction_status;
            $new_transaction->transaction_id = $transaction_id;
            $new_transaction->request_id = $transaction_request_id;
            $new_transaction->save();

            $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();


            //inserting into the activity table
            $data = strtotime(date("Y-m-d"));
            $week = date("W", $data);
            $day = date("d",$data);
            $activity = new Activities();
            $activity->user_id = auth()->user()->id;
            $activity->transaction_type = "debit";
            $activity->activity_type = $product_name;
            $activity->amount = $request->amount;
            $activity->api_platform = "vtpass";
            $activity->day = $day;
            $activity->week = $week;
            $activity->platform_table_id = $latest_vtpass_transaction->id;
            $activity->month = date("F");
            $activity->year = date("Y");
            $activity->save();

            $latest_activity = Activities::where("user_id","=",auth()->user()->id)->orderBy("id","desc")->first();

           
            //deducting from wallet
            $wallet_balance = $this->userDetails()->wallet;
            $new_wallet_balance = $wallet_balance - $user_charge;

            //updating wallet balance 
            User::findOrFail(auth()->user()->id)->update([
              "wallet" => $new_wallet_balance
            ]);
      

              $transaction_data = array(
                "activity_id" => $latest_activity->id,
                "product_name" => $product_name,
                 "amount" => $amount,
                 "amount_charged" => $user_charge,
                 "transaction_id" => $transaction_id,
                 "customer_name" => $this->userDetails()->fullname,
                 "mobile_number" => $request->mobile_number,
                 "date" => date("Y-m-d")

              );
            

          
             return response()->json([
                 "status" => true,
                 "transaction_data" => $transaction_data,
                 "admin_share" => $admin_share,
                 "transaction_id" => "mobile_number",$request->mobile_number
                 ]);
          
          

        }else{
            $user = User::find(auth()->user()->id);
            mail("michaelchuks40@gmail.com","Failed Transaction","$user->fullname could not process his transaction please, login to the dashboard and check the issue. maybe globaleasysub wallet balance on VTPASS has exhausted or there is a network glitch");
            return response()->json([
                "status" => false,
                "message" => "transaction could not be processed please try again later"
                ]);
       
        }

    }



      public function vtpassAirtimeSuccess(Request $request){
      
        $transaction_data = $request->transaction_data;
            $remaining_share =  $request->admin_share;
             $transaction_id = $request->transaction_id;
            $user = User::find(auth()->user()->id);
              $admin_share = $remaining_share;
           
           //end of share
           VtpassTransactions::find($transaction_id)->update([
            "admin_share" => $admin_share
           ]);
           
         $admin = Admin::first();
        $admin_balance = $admin->wallet;
        $new_admin_balance = $admin_balance + $admin_share;
        Admin::find($admin->id)->update([
            "wallet" => $new_admin_balance
        ]);
            
     
        $admin_earning = new AdminEarnings();
        $admin_earning->user = $user->fullname;
        $admin_earning->activity = "Airtime recharge";
        $admin_earning->amount = $admin_share;
        $admin_earning->save();

       // Mail::to($user->email)->send(new TransactionEmail($transaction_data));

          return response()->json([
              "status" => true,
              "message" => "airtime recharge was successful"
              ]);
      
      }

    



    // 2. DATA

 public function vtpassData(){
      $vtpass_data_services = VtpassServiceIdentifiers::where("identifier","=","data")->get();
      return response()->json([
          "status" => true,
          "data_services" => $vtpass_data_services
          ]);
    }


    public function vtpassDataVariations(Request $request){
   
        $service_id = $request->network;
        $url = $this->sandbox_url."service-variations?serviceID=$service_id";
        $response = $this->makeGetRequest($url);
       $variations = $response["content"]["varations"];
    
       
       return response()->json([
           "status" => true,
            "mobile_number" => $request->mobile_number,
            "data_variations" => $variations,
            "service_id" => $service_id
           ]);
     
    }




    public function confirmVtpassData(Request $request){
          $amount = $request->amount;
          $mobile_number = $request->mobile_number;
          $service_id = $request->service_id;
          $variation_code = $request->data_package;

          $wallet_balance = $this->userDetails()->wallet;
          if($wallet_balance < $request->amount){
              return response()->json([
                  "status" => false,
                  "message" => "insufficient wallet balance"
                  ]);
          
          }else{
     
           return response()->json([
               "status" => true,
               "amount" => $amount,
               "mobile_number" => $mobile_number,
               "service_id" => $service_id,
               "variation_code" => $variation_code
               ]);
       
         }

    }

   

    public function vtpassDataTopup(Request $request){
   

        $date = date("Y-m-d H:i:s");
        $time_seconds = strtotime($date) + 3600;
       $current_time = date("YmdHi",$time_seconds);
         
         $request_id = $current_time."michael";
      
        $params = [
          "request_id" => $request_id,
          "serviceID" => $request->serviceID,
          "billersCode" => $request->mobile_number,
          "variation_code" => $request->variation_code,
          "amount" => $request->amount,
          "phone" => $request->mobile_number,
        ];
  
        $url = $this->sandbox_url."pay";
  
        $response = $this->makePostRequest($url,$params);

       
       
          
          $transaction_status = $response["response_description"];
  
          if($transaction_status == "TRANSACTION SUCCESSFUL"){
            $transaction_request_id = $response["requestId"];
            $amount = $response["amount"];
  
            $transaction_details = $response["content"]["transactions"];
            $product_name = $transaction_details["product_name"];
            $unique_equivalent = $transaction_details["unique_element"];
            $amount_charged = $transaction_details["total_amount"];
            $transaction_id = $transaction_details["transactionId"];
            $commision = $transaction_details["commission"];
  
              
  
            //getting the transaction charge for this transaction
              $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=","end user")->first();
              $user_commision = ($transaction_charge->charge/100) * $commision;
              $admin_share = $commision - $user_commision;
              $user_charge = $amount_charged + $admin_share;
              
              $user = User::find(auth()->user()->id);
              
      
  
              //inserting into the vtpass transaction table
              $new_transaction = new VtpassTransactions();
              $new_transaction->user_id = auth()->user()->id;
              $new_transaction->transaction_type = "data";
              $new_transaction->product_name = $product_name;
              $new_transaction->unique_equivalent = $unique_equivalent;
              $new_transaction->amount = $amount;
              $new_transaction->amount_charged = $amount_charged;
              $new_transaction->user_charge = $user_charge;
              $new_transaction->admin_share = 0.00;
              $new_transaction->status = $transaction_status;
              $new_transaction->transaction_id = $transaction_id;
              $new_transaction->request_id = $transaction_request_id;
              $new_transaction->save();
  
              $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();
          
  
              //inserting into the activity table
              $data = strtotime(date("Y-m-d"));
            $week = date("W", $data);
            $day = date("d",$data);
              $activity = new Activities();
              $activity->user_id = auth()->user()->id;
              $activity->transaction_type = "debit";
              $activity->activity_type = $product_name;
              $activity->amount = $request->amount;
              $activity->api_platform = "vtpass";
              $activity->day = $day;
              $activity->week = $week;
              $activity->platform_table_id = $latest_vtpass_transaction->id;
              $activity->month = date("F");
              $activity->year = date("Y");
              $activity->save();

              $latest_activity = Activities::where("user_id","=",auth()->user()->id)->orderBy("id","desc")->first();

  
             
              //deducting from wallet
              $wallet_balance = $this->userDetails()->wallet;
              $new_wallet_balance = $wallet_balance - $user_charge;
  
              //updating wallet balance 
              User::findOrFail(auth()->user()->id)->update([
                "wallet" => $new_wallet_balance
              ]);
        
  
                $transaction_data = array(
                  "activity_id" => $latest_activity->id,
                  "product_name" => $product_name,
                   "amount" => $amount,
                   "amount_charged" => $user_charge,
                   "transaction_id" => $transaction_id,
                   "customer_name" => $this->userDetails()->fullname,
                   "mobile_number" => $request->mobile_number,
                   "date" => date("Y-m-d")
  
                );
              
  
  
          
       
  
              return response()->json([
                  "status" => true,
                  "transaction_data" => $transaction_data,
                  "admin_share" => $admin_share,
                  "transaction_id" => $latest_vtpass_transaction->id
                  ]);
            
  
          }else{
               $user = User::find(auth()->user()->id);
            mail("michaelchuks40@gmail.com","Failed Transaction","$user->username could not process his transaction please, login to the dashboard and check the issue. maybe globaleasysub wallet balance on VTPASS has exhausted or there is a network glitch");
            return response()->json([
                "status" => true,
                "message" => "transaction could not be processed please try again later"
                ]);
          }

    }
    





    public function vtpassDataSuccess(Request $request){
        $transaction_data = $request->transaction_data;
            $remaining_share =  $request->admin_share;
             $transaction_id = $request->transaction_id;
            $user = User::find(auth()->user()->id);
   
          $admin_share = $remaining_share;
  

     
         //end of share
         
           VtpassTransactions::find($transaction_id)->update([
            "admin_share" => $admin_share
           ]);
           
         $admin = Admin::first();
        $admin_balance = $admin->wallet;
        $new_admin_balance = $admin_balance + $admin_share;
        Admin::find($admin->id)->update([
            "wallet" => $new_admin_balance
        ]);
            
     
        $admin_earning = new AdminEarnings();
        $admin_earning->user = $user->fullname;
        $admin_earning->activity = "Airtime recharge";
        $admin_earning->amount = $admin_share;
        $admin_earning->save();
        
        return response()->json([
            "status" => true,
            "message" => "transaction processed successfully"
            ]);
      
      

    }



   //3 cable subscription

     public function vtpassCableSubscription(){
      $cable_services = VtpassServiceIdentifiers::where("identifier","=","tv-subscription")->get();
      return response()->json([
          "status" => true,
          "cable_services" => $cable_services
          ]);

    }


  


    public function cableVariations(Request $request){
   
        $service_id = $request->network;
        $url = $this->sandbox_url."service-variations?serviceID=$service_id";
        $response = $this->makeGetRequest($url);
         $service_name = $response["content"]["ServiceName"];
         $variations = $response["content"]["varations"];

         
         return response()->json([
             "status" => true,
             "service_name" => $service_name,
             "service_id" => $service_id,
             "variations" =>$variations
             ]);

 
    }
   



    public function confirmVtpassCableSub(Request $request){
    
          $wallet_balance = $this->userDetails()->wallet;
          if($wallet_balance < $request->amount){
              return response()->json([
                  "status" => true,
                  "message" => "insufficient wallet balance"
                  ]);
       
          }
         

             //varifying smart card number 
             $params = [
               "billersCode" => $request->smartcard_number,
               "serviceID" => $request->service_id
             ];


              $url = $this->sandbox_url. "merchant-verify";
              $response = $this->makePostRequest($url,$params);
              $customer_name = $response["content"]["Customer_Name"];
              $customer_number = $request->smartcard_number;

              $payment_details = array(
                "customer_name" => $customer_name,
                "customer_number" => $customer_number,
                "amount" => $request->amount,
                "service_id" => $request->service_id,
                "variation_code" => $request->cable_package,
                "mobile_number" => $request->mobile_number,
                "smartcard_number" => $request->smartcard_number
              );

           
              
              return response()->json([
                  "status" => true,
                  "service_name" => $service_name,
                  "payment_details" => $payment_details
                  ]);

          

    
    }




    public function vtpassCableSub(Request $request){
  
        $date = date("Y-m-d H:i:s");
        $time_seconds = strtotime($date) + 3600;
        $current_time = date("YmdHi",$time_seconds);
         $request_id = $current_time."michael";

            if($request->service_name == "ShowMax"){
              $params = [
                    "request_id" => $request_id,
                     "serviceID" => $request->serviceID,
                     "billersCode" => $request->mobile_number,
                     "variation_code" => $request->variation_code,
                     "amount"  => $request->amount,
                     "phone" => $request->mobile_number

              ];

            }else if($request->service_name == "Startimes Subscription"){
              $params = [
                "request_id" => $request_id,
                 "serviceID" => $request->serviceID,
                 "billersCode" => $request->smartcard_number,
                 "variation_code" => $request->variation_code,
                 "amount"  => $request->amount,
                 "phone" => $request->mobile_number

          ];

            }else{
             
              $params = [
                "request_id" => $request_id,
                 "serviceID" => $request->serviceID,
                 "billersCode" => $request->smartcard_number,
                 "variation_code" => $request->variation_code,
                 "amount"  => $request->amount,
                 "phone" => $request->mobile_number,
                 "subscription_type" => "change",
                 "quantity" => "1"

          ];


            }


    $url = $this->sandbox_url."pay";
    $response = $this->makePostRequest($url,$params);
   
    $transaction_status = $response["response_description"];
  
          if($transaction_status == "TRANSACTION SUCCESSFUL"){
            $transaction_request_id = $response["requestId"];
            $amount = $response["amount"];
  
            $transaction_details = $response["content"]["transactions"];
            $product_name = $transaction_details["product_name"];
            $unique_equivalent = $transaction_details["unique_element"];
            $amount_charged = $transaction_details["total_amount"];
            $transaction_id = $transaction_details["transactionId"];
            $commision = $transaction_details["commission"];
  
              
  
            //getting the transaction charge for this transaction
              $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=","end user")->first();
              $user_commision = ($transaction_charge->charge/100) * $commision;
              $admin_share = $commision - $user_commision;
              $user_charge = $amount_charged + $admin_share;

            
  
              //inserting into the vtpass transaction table
              $new_transaction = new VtpassTransactions();
              $new_transaction->user_id = auth()->user()->id;
              $new_transaction->transaction_type = "cable";
              $new_transaction->product_name = $product_name;
              $new_transaction->unique_equivalent = $unique_equivalent;
              $new_transaction->amount = $amount;
              $new_transaction->amount_charged = $amount_charged;
              $new_transaction->user_charge = $user_charge;
              $new_transaction->admin_share = 0.00;
              $new_transaction->status = $transaction_status;
              $new_transaction->transaction_id = $transaction_id;
              $new_transaction->request_id = $transaction_request_id;
              $new_transaction->save();
  
              $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();
  
  
              //inserting into the activity table
                $data = strtotime(date("Y-m-d"));
            $week = date("W", $data);
            $day = date("d",$data);
              $activity = new Activities();
              $activity->user_id = auth()->user()->id;
              $activity->transaction_type = "debit";
              $activity->activity_type = $product_name;
              $activity->amount = $request->amount;
              $activity->api_platform = "vtpass";
              $activity->day = $day;
              $activity->week = $week;
              $activity->platform_table_id = $latest_vtpass_transaction->id;
              $activity->month = date("F");
              $activity->year = date("Y");
              $activity->save();

              $latest_activity = Activities::where("user_id","=",auth()->user()->id)->orderBy("id","desc")->first();

  
             
              //deducting from wallet
              $wallet_balance = $this->userDetails()->wallet;
              $new_wallet_balance = $wallet_balance - $user_charge;
  
              //updating wallet balance 
              User::findOrFail(auth()->user()->id)->update([
                "wallet" => $new_wallet_balance
              ]);
        
  
                $transaction_data = array(
                  "activity_id" => $latest_activity->id,
                  "product_name" => $product_name,
                   "amount" => $amount,
                   "amount_charged" => $user_charge,
                   "transaction_id" => $transaction_id,
                   "customer_name" => $this->userDetails()->username,
                   "smartcard_number" => $unique_equivalent,
                   "mobile_number" => $request->mobile_number,
                   "date" => date("Y-m-d")
  
                );
              

            return response()->json([
                "status" => true,
                "admin_share" => $admin_share,
                "transaction_id" =>  $latest_vtpass_transaction->id
                ]);
            
  
          }else{
               $user = User::find(auth()->user()->id);
            mail("michaelchuks40@gmail.com","Failed Transaction","$user->username could not process his transaction please, login to the dashboard and check the issue. maybe globaleasysub wallet balance on VTPASS has exhausted or there is a network glitch");
            return response()->json([
                "status" => false,
                "message" => "transaction could not be processed please try again later"
                ]);
          
          }


    }







    public function vtpassCableSuccess(Request $request){
   
        $transaction_data = $request->transaction_data;
          $remaining_share = $request->admin_share;
             $transaction_id = $request->transaction_id;
            $user = User::find(auth()->user()->id);

            $admin_share = $remaining_share;
  
           //end of share
           VtpassTransactions::find($transaction_id)->update([
            "admin_share" => $admin_share
           ]);
           
         $admin = Admin::first();
        $admin_balance = $admin->wallet;
        $new_admin_balance = $admin_balance + $admin_share;
        Admin::find($admin->id)->update([
            "wallet" => $new_admin_balance
        ]);
            
     
        $admin_earning = new AdminEarnings();
        $admin_earning->user = $user->username;
        $admin_earning->activity = "Cable Subscription";
        $admin_earning->amount = $admin_share;
        $admin_earning->save();

         return response()->json([
             "status" => true,
             "message" => "cable subscription was successful"
             ]);
      
      

    }





    public function vtpassElectricity(){
     
            $electricity_services = VtpassServiceIdentifiers::where("identifier","=","electricity-bill")->get();
            return  response()->json([
                "status" => true,
                "electricity_services" => $electricity_services
                ]);
       
      
    }


    public function confirmElectrilBill(Request $request){
  
        $wallet_balance = $this->userDetails()->wallet;
        if($wallet_balance < $request->amount){
          return response()->json([
              "status" => false,
               "message" => "insufficient wallet balance"
              ]);
        }
        //variefaying meter number
        $url = $this->sandbox_url."merchant-verify";
       
       
        $params = [
          "billersCode" => $request->billersCode,
          "serviceID" => $request->serviceID,
          "type" => $request->variation_code
        ];

        $response = $this->makePostRequest($url,$params);
        $meter_details = $response["content"];

       // dd($meter_details);
      
       

        $customer_name = $meter_details["Customer_Name"];
          if($request->serviceID == "abuja-electric" || $request->serviceID == "portharcourt-electric" || $request->serviceID == "jos-electric" || $request->serviceID == "ibadan-electric"){
        $meter_number = $meter_details["MeterNumber"];
          }else{
            $meter_number = $meter_details["Meter_Number"];
          }

          if($request->serviceID == "enugu-electric"){
            $address = $meter_details["District"];
           }else{
            $address = $meter_details["Address"];
           }


       // $address = $meter_details["Address"];

        $payment_details = array(
          "customer_name" => $customer_name,
          "meter_number" => $meter_number,
          "address" => $address,
          "variation_code" => $request->variation_code,
          "phone" => $request->phone,
          "amount" => $request->amount,
          "serviceID" => $request->serviceID,
          "billersCode" => $request->billersCode
        );

        return response()->json([
            "status" => true,
            "payment_details" => $payment_details
            ]);

     
    }



    public function electricityRecharge(Request $request){
  

        $date = date("Y-m-d H:i:s");
        $time_seconds = strtotime($date) + 3600;
        $current_time = date("YmdHi",$time_seconds);
         $request_id = $current_time."michael";
      


        $params = [
          "request_id" => $request_id,
           "serviceID" => $request->serviceID,
           "billersCode" => $request->billersCode,
           "type" => $request->variation_code,
           "amount"  => $request->amount,
           "phone" => $request->phone,
          

    ];

    $url = $this->sandbox_url."pay";

    $response = $this->makePostRequest($url,$params);
   
   return $response;

    $transaction_status = $response["response_description"];
  
    if($transaction_status == "TRANSACTION SUCCESSFUL"){
      $transaction_request_id = $response["requestId"];
      $amount = $response["amount"];
      $token = $response["purchased_code"];
      if(isset($response["units"])){
        $units = $response["units"];
      }else if(isset($response["mainTokenUnits"])){
        $units = $response["mainTokenUnits"];
      }else{
        $units = "";
      }
      

      $transaction_details = $response["content"]["transactions"];
      $product_name = $transaction_details["product_name"];
      $unique_equivalent = $transaction_details["unique_element"];
      $amount_charged = $transaction_details["total_amount"];
      $transaction_id = $transaction_details["transactionId"];
      $commision = $transaction_details["commission"];

        

      //getting the transaction charge for this transaction
        $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=","end user")->first();
        $user_commision = ($transaction_charge->charge/100) * $commision;
        $admin_share = $commision - $user_commision;
        $user_charge = $amount_charged + $admin_share;
        
     
      

        //inserting into the vtpass transaction table
        $new_transaction = new VtpassTransactions();
        $new_transaction->user_id = auth()->user()->id;
        $new_transaction->transaction_type = "electricity";
        $new_transaction->product_name = $product_name;
        $new_transaction->unique_equivalent = $unique_equivalent;
        $new_transaction->amount = $amount;
        $new_transaction->amount_charged = $amount_charged;
        $new_transaction->user_charge = $user_charge;
        $new_transaction->admin_share = 0.00;
        $new_transaction->status = $transaction_status;
        $new_transaction->transaction_id = $transaction_id;
        $new_transaction->request_id = $transaction_request_id;
        $new_transaction->save();

        $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();


        //inserting into the activity table
          $data = strtotime(date("Y-m-d"));
            $week = date("W", $data);
            $day = date("d",$data);
        $activity = new Activities();
        $activity->user_id = auth()->user()->id;
        $activity->transaction_type = "debit";
        $activity->activity_type = $product_name;
        $activity->amount = $request->amount;
        $activity->api_platform = "vtpass";
        $activity->day = $day;
        $activity->week = $week;
        $activity->platform_table_id = $latest_vtpass_transaction->id;
        $activity->month = date("F");
        $activity->year = date("Y");
        $activity->save();

        $latest_activity = Activities::where("user_id","=",auth()->user()->id)->orderBy("id","desc")->first();


        //inserting tokens
        $new_token = new ElectricityTokens();
        $new_token->user_id = auth()->user()->id;
        $new_token->platform_table_id = $latest_vtpass_transaction->id;
        $new_token->api_platform = "vtpass";
        $new_token->token = $token;
        $new_token->units = $units;
        $new_token->save();

       
        //deducting from wallet
        $wallet_balance = $this->userDetails()->wallet;
        $new_wallet_balance = $wallet_balance - $user_charge;

        //updating wallet balance 
        User::findOrFail(auth()->user()->id)->update([
          "wallet" => $new_wallet_balance
        ]);
  

          $transaction_data = array(
            "activity_id" => $latest_activity->id,
            "product_name" => $product_name,
             "amount" => $amount,
             "amount_charged" => $user_charge,
             "transaction_id" => $transaction_id,
             "customer_name" => $this->userDetails()->fullname,
             "meter_number" => $unique_equivalent,
             "mobile_number" => $request->phone,
             "date" => date("Y-m-d"),
             "token" => $token,
             "units" => $units

          );
        

            return response()->json([
                "status" => true,
                "transaction_data" => $transaction_data,
                "admin_share" => $admin_share,
                "transaction_id" => $latest_vtpass_transaction->id
                ]);
       
       
      

    }else{
         $user = User::find(auth()->user()->id);
            mail("michaelchuks40@gmail.com","Failed Transaction","$user->username could not process his transaction please, login to the dashboard and check the issue. maybe globaleasysub wallet balance on VTPASS has exhausted or there is a network glitch");
      return response()->json([
          "status" => false,
          "message" => "transaction could not be processed please try again later"
          ]);
    }
      
  
    }





    public function electricityBillSuccess(Request $request){
   
        $transaction_data = $request->transaction_data;
         $remaining_share =  $request->admin_share;
             $transaction_id = $request->transaction_id;
            $user = User::find(auth()->user()->id);
   $admin_share = $remaining_share;

           //end of share
           VtpassTransactions::find($transaction_id)->update([
            "admin_share" => $admin_share
           ]);
           
         $admin = Admin::first();
        $admin_balance = $admin->wallet;
        $new_admin_balance = $admin_balance + $admin_share;
        Admin::find($admin->id)->update([
            "wallet" => $new_admin_balance
        ]);
            
     
        $admin_earning = new AdminEarnings();
        $admin_earning->user = $user->username;
        $admin_earning->activity = "Electricity";
        $admin_earning->amount = $admin_share;
        $admin_earning->save();

      
       return response()->json([
           "status" => true,
           "message" => "Electricity recharge was successful"
           ]);
      
     
      
      

    }




    public function checkId(){
      $url = "https://sandbox.vtpass.com/api/services?identifier=electricity-bill";
      $response = $this->makeGetRequest($url);
      dd($response);
    }





 public function education(){
  $education_services = VtpassServiceIdentifiers::where("identifier","=","education")->get();
  return view("users.dashboard.education.vtpass_education")->with("education_services",$education_services);

}


public function educationType(Request $request){
  $service_id = $request->serviceID;
  if($service_id == "waec"){
    return redirect()->to("/waec");
  }else if($service_id == "waec-registration"){
    return redirect()->to("weac-registration");
  }
}

public function waec(){
  $waec_details = VtpassServiceIdentifiers::where("service_id","=","waec")->first();
  $url = $this->sandbox_url."service-variations?serviceID=waec";
  $response = $this->makeGetRequest($url);
   $service_name = $response["content"]["ServiceName"];
   $variations = $response["content"]["varations"];
   return view("users.dashboard.education.waec")->with("variations",$variations)
   ->with("service_name",$service_name)
   ->with("service_id","waec");
}



public function confirmWaecPayment(Request $request){
   $charges = EducationCharges::orderBy("id","desc")->first();
   $serviceID = $request->service_id;
   $variation_code = $request->data_package;
   $amount = $request->amount;
   $total_amount = $request->amount + $charges->waec;
   $phone = $request->phone_number;
   return view('users.dashboard.education.confirmwaec')->with("amount",$amount)->with("serviceID",$serviceID)->with("total_amount",$total_amount)
   ->with("variation_code",$variation_code)->with("phone",$phone);
}



public function getWaecPin(Request $request){
 // dd($request->all());
  if($request->has("get_pin_btn")){
     $wallet_balance = $this->userDetails()->wallet;
     if($wallet_balance < $request->total_amount){
         return redirect()->to("/education")->with("error","Insufficient wallet balance");
     }else{
      $date = date("Y-m-d H:i:s");
      $time_seconds = strtotime($date);
      $difference = $time_seconds;
      $current_time = date("YmdHi",$difference);
       $request_id = $current_time."michael";
    


      $params = [
        "request_id" => $request_id,
         "serviceID" => $request->serviceID,
         "variation_code" => $request->variation_code,
         "amount"  => $request->amount,
         "phone" => $request->mobile_number,
        

  ];

  $url = $this->sandbox_url."pay";

  $response = $this->makePostRequest($url,$params);
 
 

  $transaction_status = $response["response_description"];

  if($transaction_status == "TRANSACTION SUCCESSFUL"){
    $transaction_request_id = $response["requestId"];
    $amount = $response["amount"];
    
     $pin = $response["cards"][0]["Pin"];
     $serial_no = $response["cards"][0]["Serial"];
    
      $admin_share = $request->total_amount - $amount;
      $user_charge = $request->total_amount;
      
      
     
    

      //inserting into the vtpass transaction table
      $new_transaction = new VtpassTransactions();
      $new_transaction->user_id = session()->get("loggedUser");
      $new_transaction->transaction_type = "education";
      $new_transaction->product_name = "waec result checker pin";
      $new_transaction->unique_equivalent = $request->mobile_number;
      $new_transaction->amount = $amount;
      $new_transaction->amount_charged = $request->total_amount;
      $new_transaction->user_charge = $user_charge;
      $new_transaction->admin_share = 0.00;
      $new_transaction->status = $transaction_status;
      $new_transaction->transaction_id = $transaction_request_id;
      $new_transaction->request_id = $transaction_request_id;
      $new_transaction->save();

      $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();


      //inserting into the activity table
      $activity = new Activities();
      $activity->user_id = session()->get("loggedUser");
      $activity->activity_type = "waec result checker pin";
      $activity->api_platform = "vtpass";
      $activity->platform_table_id = $latest_vtpass_transaction->id;
      $activity->month = date("F");
      $activity->year = date("Y");
      $activity->save();

      $latest_activity = Activities::where("user_id","=",session()->get("loggedUser"))->orderBy("id","desc")->first();


     
      //deducting from wallet
      $wallet_balance = $this->userDetails()->wallet;
      $new_wallet_balance = $wallet_balance - $user_charge;

      //updating wallet balance 
      User::findOrFail(session()->get("loggedUser"))->update([
        "wallet" => $new_wallet_balance
      ]);


        $transaction_data = array(
          "activity_id" => $latest_activity->id,
          "product_name" => "waec result checker pin",
           "amount" => $user_charge,
           "amount_charged" => $user_charge,
           "transaction_id" => $transaction_request_id,
           "customer_name" => $this->userDetails()->username,
           "Pin" => $pin,
           "mobile_number" => $request->mobile_number,
           "date" => date("Y-m-d"),
           "serial" => $serial_no,
           

        );
      


      session()->put("transaction_data",$transaction_data);
       session()->put("admin_share",$admin_share);
            session()->put("transaction_id", $latest_vtpass_transaction->id);
    

      return redirect()->to("/waecpinsuccess");
    

  }else{
    $user = User::find(session()->get("loggedUser"));
            mail("globaleasysub@gmail.com","Failed Transaction","$user->username could not process his transaction please, login to the dashboard and check the issue. maybe globaleasysub wallet balance on VTPASS has exhausted or there is a network glitch");
    return redirect()->to("/education")->with("error","transaction could not be processed please try again later");
  }
    
     }

   
  }else{
    return redirect()->to("/login");
  }
}



public function waecPinSuccess(){
    if(!session()->has("transaction_data")){
      return redirect()->to("/education");
    }else{
      $transaction_data = session()->get("transaction_data");
       $remaining_share =  session()->get("admin_share");
             $transaction_id = session()->get("transaction_id");
            $user = User::find(session()->get("loggedUser"));

   $admin_share = $remaining_share;
 
           //end of share
           VtpassTransactions::find($transaction_id)->update([
            "admin_share" => $admin_share
           ]);
           
         $admin = Admin::first();
        $admin_balance = $admin->wallet;
        $new_admin_balance = $admin_balance + $admin_share;
        Admin::find($admin->id)->update([
            "wallet" => $new_admin_balance
        ]);
            
     
        $admin_earning = new AdminEarnings();
        $admin_earning->user = $user->username;
        $admin_earning->activity = "Cable Subscription";
        $admin_earning->amount = $admin_share;
        $admin_earning->save();

           session()->pull("transaction_data");
           session()->pull("amount");
           session()->pull("original_charge");
           session()->pull("transaction_id");
      return view("users.dashboard.education.waecpinsuccess")->with("transaction_data",$transaction_data);
    }
 
}








}
