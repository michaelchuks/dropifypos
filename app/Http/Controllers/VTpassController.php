<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VTpassServices;
use App\Models\VtpassServiceIdentifiers;
use App\Models\TransactionCharges;
use App\Models\VtpassTransactions;
use App\Models\Activities;
use App\Models\User;

class VTpassController extends Controller
{
    public $api_key = "";
    public $sandbox_url = "https://vtpass.com/api/";
    //public $sandbox_url = "https://sandbox.vtpass.com/api/";
     public $username = "dropify2018@gmail.com";
     public $password = "Prinbhobhoangel24#";
     
       //public $username = "globaleasysub@gmail.com";
     //public $password = "Iheanacho44#";
 
 
 
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
         $user_details = User::findOrFail(session()->get("loggedUser"));
         return $user_details;
       }
 
 
 
       
     //method to get admin api balance
      public function getBalance(){
      $url = $this->sandbox_url . "balance";
      $balance_details = $this->makeGetRequest($url);
      $wallet_balance = $balance_details["contents"]["balance"];
      dd($wallet_balance);
 
      }
 
 
 
      public function checkUser($user_id){
       $user = User::find($user_id);
       if($user == null){
         echo "<script>
           location.href='https://arigopay.com';
         </script>";
       }
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
       dd($services);
 
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
       return view("users.dashboard.airtime.vtpassairtime")->with("airtime_services",$vtpass_airtime_services);
 
     }
 
 
 
     public function confirmVtpassAirtime(Request $request){
       $request->validate([
         "mobile_number" => "required",
         "amount" => "required",
         "network" => "required",         
       ]);
 
      $wallet_balance = $this->userDetails()->wallet;
      if($wallet_balance < $request->amount){
        return redirect()->back()->with("error","insufficient wallet balance");
      }else{
 
      $airtime_details = VtpassServiceIdentifiers::where("service_id","=",$request->network)->first();
      return view("users.dashboard.airtime.confirmvtpassairtime")->with("airtime_details",$airtime_details)
      ->with("amount",$request->amount)
      ->with("mobile_number",$request->mobile_number);
     }
     }
 
 
 
     public function vtpassAirtimeRecharge(Request $request){
         
         $pin = $request->transaction_pin;
         $user = $this->userDetails();
         if($pin != $user->transaction_pin){
              return redirect()->to("/airtime")->with("error","Incporrect transaction pin");
         }
   
       $date = date("Y-m-d H:i:s");
       $time_seconds = strtotime($date);
       $difference = $time_seconds;
        $current_time = date("YmdHi",$difference);
        
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
             $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=",$this->userDetails()->package_type)->first();
             $user_commision = ($transaction_charge->charge/100) * $commision;
             $admin_share = $commision - $user_commision;
             $user_charge = $amount_charged + $admin_share;
           
 
             //inserting into the vtpass transaction table
             $new_transaction = new VtpassTransactions();
             $new_transaction->user_id = session()->get("loggedUser");
             $new_transaction->transaction_type = "airtime";
             $new_transaction->product_name = $product_name;
             $new_transaction->unique_equivalent = $unique_equivalent;
             $new_transaction->amount = $amount;
             $new_transaction->amount_charged = $amount_charged;
             $new_transaction->user_charge = $user_charge;
             $new_transaction->admin_share = $admin_share;
             $new_transaction->status = $transaction_status;
             $new_transaction->transaction_id = $transaction_id;
             $new_transaction->request_id = $transaction_request_id;
             $new_transaction->save();
 
             $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();
 
 
             //inserting into the activity table
             $activity = new Activities();
             $activity->user_id = session()->get("loggedUser");
             $activity->activity_type = $product_name;
             $activity->api_platform = "vtpass";
             $activity->platform_table_id = $latest_vtpass_transaction->id;
             $activity->month = date("F");
             $activity->year = date("Y");
             $activity->save();
 
            
             //deducting from wallet
             $wallet_balance = $this->userDetails()->wallet;
             $new_wallet_balance = $wallet_balance - $user_charge;
 
             //updating wallet balance 
             User::findOrFail(session()->get("loggedUser"))->update([
               "wallet" => $new_wallet_balance
             ]);
       
 
               $transaction_data = array(
                 "product_name" => $product_name,
                  "amount" => $amount,
                  "amount_charged" => $user_charge,
                  "transaction_id" => $transaction_id,
                  "customer_name" => $this->userDetails()->username,
                  "mobile_number" => $request->mobile_number,
                  "date" => date("Y-m-d")
 
               );
             
 
 
             session()->put("transaction_data",$transaction_data);
           
 
             return redirect()->to("/airtimesuccess");
           
 
         }else{
          
           return redirect()->to("/airtime")->with("error","transaction could not be processed please try again later");
         }
 
     }
 
 
 
     public function vtpassAirtimeSuccess(){
       
       if(!session()->has("transaction_data")){
         return redirect()->to("/airtime");
       }else{
         $transaction_data = session()->get("transaction_data");
       
 
         session()->pull("transaction_data");
       
         return view("users.dashboard.airtime.vtpass_airtimesuccess")
         ->with("transaction_data",$transaction_data);
       
       }
     }
 
     public function airtimeToCash(){
       $vtpass_airtime_services = VtpassServiceIdentifiers::where("identifier","=","airtime")->get();
       return view("users.dashboard.airtime.airtime_to_cash")->with("airtime_services",$vtpass_airtime_services);
     }
 
 
 
     public function processAirtime(Request $request){
       $request->validate([
         "card_digits" => "required",
         "amount" => "required",
         "network" => "required",         
       ]);
 
       $airtime = new AirtimeToCash();
       $airtime->user_id = session()->get("loggedUser");
       $airtime->network = $request->network;
       $airtime->card_digits = $request->card_digits;
       $airtime->amount = $request->amount;
       $airtime->save();
       return redirect()->back()->with("success","your wallet will be credited once the airime is confirmed to be valid");
 
     
     }
     
 
 
 
     // 2. DATA
 
 
     public function vtpassData(){
     
       $vtpass_data_services = VtpassServiceIdentifiers::where("identifier","=","data")->get();
       return view("users.dashboard.data.vtpass_data")
       ->with("data_services",$vtpass_data_services);
     }
 
 
     public function vtpassDataVariations(Request $request){
       if($request->has("data_variation_btn")){
         $service_id = $request->network;
         $url = $this->sandbox_url."service-variations?serviceID=$service_id";
         $response = $this->makeGetRequest($url);
        $variations = $response["content"]["varations"];
        return view("users.dashboard.data.vtpass_data_variations")->with("mobile_number",$request->mobile_number)
        ->with("data_variations",$variations)
        ->with("service_id",$service_id);
       }else{
         return redirect()->to("/");
       }
     }
 
 
 
 
     public function confirmVtpassData(Request $request){
       if($request->has("confirm_vtpass_data_btn")){
           $amount = $request->amount;
           $mobile_number = $request->mobile_number;
           $service_id = $request->service_id;
           $variation_code = $request->data_package;
 
           $wallet_balance = $this->userDetails()->wallet;
           if($wallet_balance < $request->amount){
            
             return redirect()->to("/data")->with("error","insufficient wallet balance");
           }else{
      
           
           return view("users.dashboard.data.confirmvtpassdata")->with("service_id",$service_id)
           ->with("amount",$amount)
           ->with("mobile_number",$mobile_number)
           ->with("variation_code",$variation_code);
          }
 
 
       }else{
         return redirect()->to("/");
       }
     }
 
    
 
     public function vtpassDataTopup(Request $request){
       if($request->has("data_topup_btn")){
           
           $pin = $request->transaction_pin;
         $user = $this->userDetails();
         if($pin != $user->transaction_pin){
              return redirect()->to("/data")->with("error","Incporrect transaction pin");
         }
 
         $date = date("Y-m-d H:i:s");
         $time_seconds = strtotime($date);
       
 
        $difference = $time_seconds;
        $current_time = date("YmdHi",$difference);
          
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
               $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=",$this->userDetails()->package_type)->first();
               $user_commision = ($transaction_charge->charge/100) * $commision;
               $admin_share = $commision - $user_commision;
               $user_charge = $amount_charged + $admin_share;
             
   
               //inserting into the vtpass transaction table
               $new_transaction = new VtpassTransactions();
               $new_transaction->user_id = session()->get("loggedUser");
               $new_transaction->transaction_type = "data";
               $new_transaction->product_name = $product_name;
               $new_transaction->unique_equivalent = $unique_equivalent;
               $new_transaction->amount = $amount;
               $new_transaction->amount_charged = $amount_charged;
               $new_transaction->user_charge = $user_charge;
               $new_transaction->admin_share = $admin_share;
               $new_transaction->status = $transaction_status;
               $new_transaction->transaction_id = $transaction_id;
               $new_transaction->request_id = $transaction_request_id;
               $new_transaction->save();
   
               $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();
   
   
               //inserting into the activity table
               $activity = new Activities();
               $activity->user_id = session()->get("loggedUser");
               $activity->activity_type = $product_name;
               $activity->api_platform = "vtpass";
               $activity->platform_table_id = $latest_vtpass_transaction->id;
               $activity->month = date("F");
               $activity->year = date("Y");
               $activity->save();
   
              
               //deducting from wallet
               $wallet_balance = $this->userDetails()->wallet;
               $new_wallet_balance = $wallet_balance - $user_charge;
   
               //updating wallet balance 
               User::findOrFail(session()->get("loggedUser"))->update([
                 "wallet" => $new_wallet_balance
               ]);
         
   
                 $transaction_data = array(
                   "product_name" => $product_name,
                    "amount" => $amount,
                    "amount_charged" => $user_charge,
                    "transaction_id" => $transaction_id,
                    "customer_name" => $this->userDetails()->username,
                    "mobile_number" => $request->mobile_number,
                    "date" => date("Y-m-d")
   
                 );
               
   
   
               session()->put("transaction_data",$transaction_data);
             
   
               return redirect()->to("/datasuccess");
             
   
           }else{
            
             return redirect()->to("/data")->with("error","transaction could not be processed please try again later");
           }
 
         
       }else{
         return redirect()->to("/");
       }
     }
 
 
 
 
     public function vtpassDataSuccess(){
       
       if(!session()->has("transaction_data")){
         return redirect()->to("/data");
       }else{
         $transaction_data = session()->get("transaction_data");
       
 
         session()->pull("transaction_data");
       
         return view("users.dashboard.data.vtpass_datasuccess")
         ->with("transaction_data",$transaction_data);
       
       }
 
     }
 
 
 
    //3 cable subscription
 
     public function vtpassCableSubscription(){
     
       $cable_services = VtpassServiceIdentifiers::where("identifier","=","tv-subscription")->get();
      
       return view("users.dashboard.cable.vtpass_cable")->with("cable_services",$cable_services);
 
     }
 
 
   
 
 
     public function cableVariations(Request $request){
       if($request->has("cable_variations_btn")){
         $service_id = $request->network;
         $url = $this->sandbox_url."service-variations?serviceID=$service_id";
         $response = $this->makeGetRequest($url);
          $service_name = $response["content"]["ServiceName"];
          $variations = $response["content"]["varations"];
 
          return view("users.dashboard.cable.vtpass_cable_variations")->with("variations",$variations)
          ->with("service_name",$service_name)
          ->with("service_id",$service_id);
 
       }else{
         return redirect()->to("/");
       }
     }
    
 
 
 
     public function confirmVtpassCableSub(Request $request){
         if($request->has("confirm_vtpass_cable_btn")){
           $wallet_balance = $this->userDetails()->wallet;
           if($wallet_balance < $request->amount){
            
             return redirect()->to("/cable")->with("error","insufficient wallet balance");
           }
           if($request->service_name == "ShowMax"){
             $payment_details = array(
               "amount" => $request->amount,
               "service_id" => $request->service_id,
               "variation_code" => $request->cable_package,
               "mobile_number" => $request->mobile_number,
              
             );
             return view("users.dashboard.cable.confirmvtpasscable")->with("service_name",$request->service_name)
             ->with("payment_details",$payment_details);
 
           }else{
 
              //varifying smart card number 
              $params = [
                "billersCode" => $request->smartcard_number,
                "serviceID" => $request->service_id
              ];
 
 
               $url = $this->sandbox_url. "merchant-verify";
               $response = $this->makePostRequest($url,$params);
               if(!isset($response["content"]["Customer_Name"])){
                
                 return redirect()->to("/cable")->with("error","incorrect smart card number,please crosscheck and try again");
               }
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
 
               return view("users.dashboard.cable.confirmvtpasscable")->with("service_name",$request->service_name)
               ->with("payment_details",$payment_details);
 
           }
 
         }else{
           return redirect()->to("/");
         }
     }
 
 
 
 
     public function vtpassCableSub(Request $request){
       if($request->has("cable_sub_btn")){
           $pin = $request->transaction_pin;
         $user = $this->userDetails();
         if($pin != $user->transaction_pin){
              return redirect()->to("/cable")->with("error","Incporrect transaction pin");
         }
         $date = date("Y-m-d H:i:s");
         $time_seconds = strtotime($date);
         $difference = $time_seconds;
         $current_time = date("YmdHi",$difference);
       
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
               $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=",$this->userDetails()->package_type)->first();
               $user_commision = ($transaction_charge->charge/100) * $commision;
               $admin_share = $commision - $user_commision;
               $user_charge = $amount_charged + $admin_share;
              
             
   
               //inserting into the vtpass transaction table
               $new_transaction = new VtpassTransactions();
               $new_transaction->user_id = session()->get("loggedUser");
               $new_transaction->transaction_type = "cable";
               $new_transaction->product_name = $product_name;
               $new_transaction->unique_equivalent = $unique_equivalent;
               $new_transaction->amount = $amount;
               $new_transaction->amount_charged = $amount_charged;
               $new_transaction->user_charge = $user_charge;
               $new_transaction->admin_share = $admin_share;
               $new_transaction->status = $transaction_status;
               $new_transaction->transaction_id = $transaction_id;
               $new_transaction->request_id = $transaction_request_id;
               $new_transaction->save();
   
               $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();
   
   
               //inserting into the activity table
               $activity = new Activities();
               $activity->user_id = session()->get("loggedUser");
               $activity->activity_type = $product_name;
               $activity->api_platform = "vtpass";
               $activity->platform_table_id = $latest_vtpass_transaction->id;
               $activity->month = date("F");
               $activity->year = date("Y");
               $activity->save();
   
              
               //deducting from wallet
               $wallet_balance = $this->userDetails()->wallet;
               $new_wallet_balance = $wallet_balance - $user_charge;
   
               //updating wallet balance 
               User::findOrFail(session()->get("loggedUser"))->update([
                 "wallet" => $new_wallet_balance
               ]);
         
   
                 $transaction_data = array(
                   "product_name" => $product_name,
                    "amount" => $amount,
                    "amount_charged" => $user_charge,
                    "transaction_id" => $transaction_id,
                    "customer_name" => $this->userDetails()->username,
                    "smartcard_number" => $unique_equivalent,
                    "mobile_number" => $request->mobile_number,
                    "date" => date("Y-m-d")
   
                 );
               
   
   
               session()->put("transaction_data",$transaction_data);
             
   
               return redirect()->to("/cablesuccess");
             
   
           }else{
            
             return redirect()->to("cable")->with("error","transaction could not be processed please try again later");
           }
 
 
 
 
 
 
       }else{
         return redirect()->to("/");
       }
     }
 
 
 
 
 
 
 
     public function vtpassCableSuccess(){
       
       if(!session()->has("transaction_data")){
        
         
         return redirect()->to("cable");
       }else{
         $transaction_data = session()->get("transaction_data");
       
 
         session()->pull("transaction_data");
       
         return view("users.dashboard.cable.vtpass_cablesuccess")
         ->with("transaction_data",$transaction_data);
       
       }
 
     }
 
 
 
 
 
     public function vtpassElectricity(){
     
       $electricity_services = VtpassServiceIdentifiers::where("identifier","=","electricity-bill")->get();
       return view("users.dashboard.electricity.vtpass_electricity")->with("electricity_services",$electricity_services);
 
     }
 
 
     public function confirmElectrilBill(Request $request){
       if($request->has("electric_bills_btn")){
         $wallet_balance = $this->userDetails()->wallet;
         if($wallet_balance < $request->amount){
          
           return redirect()->to("/electricity")->with("error","insufficient wallet balance");
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
        
       
         if(!isset($meter_details["Customer_Name"])){
          
           return redirect()->to("/electricity")->with("error","invalid meter number,please crosscheck and try again");
         }
 
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
 
         return view("users.dashboard.electricity.confirmvtpasselectricity")->with("payment_details",$payment_details);
 
       }else{
         return redirect()->to("/login");
       }
     }
 
 
 
     public function electricityRecharge(Request $request){
       if($request->has("electricity_sub_btn")){
           
           $pin = $request->transaction_pin;
         $user = $this->userDetails();
         if($pin != $user->transaction_pin){
              return redirect()->to("/electricity")->with("error","Incporrect transaction pin");
         }
 
         $date = date("Y-m-d H:i:s");
         $time_seconds = strtotime($date);
         $difference = $time_seconds;
         $current_time = date("YmdHi",$difference);
          $request_id = $current_time."michael";
       
 
 
         $params = [
           "request_id" => $request_id,
            "serviceID" => $request->serviceID,
            "billersCode" => $request->billersCode,
            "variation_code" => $request->variation_code,
            "amount"  => $request->amount,
            "phone" => $request->phone,
           
 
     ];
 
     $url = $this->sandbox_url."pay";
 
     $response = $this->makePostRequest($url,$params);
    
     dd($response);
 
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
         $transaction_charge = TransactionCharges::where("api_platform","=","vtpass")->where("transaction_type","=",$product_name)->where("package_type","=",$this->userDetails()->package_type)->first();
         $user_commision = ($transaction_charge->charge/100) * $commision;
         $admin_share = $commision - $user_commision;
         $user_charge = $amount_charged + $admin_share;
        
       
 
         //inserting into the vtpass transaction table
         $new_transaction = new VtpassTransactions();
         $new_transaction->user_id = session()->get("loggedUser");
         $new_transaction->transaction_type = "electricity";
         $new_transaction->product_name = $product_name;
         $new_transaction->unique_equivalent = $unique_equivalent;
         $new_transaction->amount = $amount;
         $new_transaction->amount_charged = $amount_charged;
         $new_transaction->user_charge = $user_charge;
         $new_transaction->admin_share = $admin_share;
         $new_transaction->status = $transaction_status;
         $new_transaction->transaction_id = $transaction_id;
         $new_transaction->request_id = $transaction_request_id;
         $new_transaction->save();
 
         $latest_vtpass_transaction = VtpassTransactions::orderBy("id","desc")->first();
 
 
         //inserting into the activity table
         $activity = new Activities();
         $activity->user_id = session()->get("loggedUser");
         $activity->activity_type = $product_name;
         $activity->api_platform = "vtpass";
         $activity->platform_table_id = $latest_vtpass_transaction->id;
         $activity->month = date("F");
         $activity->year = date("Y");
         $activity->save();
 
        
         //deducting from wallet
         $wallet_balance = $this->userDetails()->wallet;
         $new_wallet_balance = $wallet_balance - $user_charge;
 
         //updating wallet balance 
         User::findOrFail(session()->get("loggedUser"))->update([
           "wallet" => $new_wallet_balance
         ]);
   
 
           $transaction_data = array(
             "product_name" => $product_name,
              "amount" => $amount,
              "amount_charged" => $user_charge,
              "transaction_id" => $transaction_id,
              "customer_name" => $this->userDetails()->username,
              "meter_number" => $unique_equivalent,
              "mobile_number" => $request->phone,
              "date" => date("Y-m-d"),
              "token" => $token,
              "units" => $units
 
           );
         
 
 
         session()->put("transaction_data",$transaction_data);
       
 
         return redirect()->to("/electricitybillsuccess");
       
 
     }else{
      
       return redirect()->to("/electricity")->with("error","transaction could not be processed please try again later");
     }
       
       }else{
         return redirect()->to("/login");
       }
     }
 
 
 
 
 
     public function electricityBillSuccess(){
       
       if(!session()->has("transaction_data")){
        
         return redirect()->to("/electricity");
       }else{
         $transaction_data = session()->get("transaction_data");
       
 
         session()->pull("transaction_data");
       
         return view("users.dashboard.electricity.vtpass_electricitysuccess")
         ->with("transaction_data",$transaction_data);
       
       }
 
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
           $pin = $request->transaction_pin;
         $user = $this->userDetails();
         if($pin != $user->transaction_pin){
              return redirect()->to("/education")->with("error","Incporrect transaction pin");
         }
          $wallet_balance = $this->userDetails()->wallet;
          if($wallet_balance < $request->total_amount){
              return redirect()->to("/education")->with("error","Insufficient wallet balance");
          }else{
           $date = date("Y-m-d H:i:s");
           $time_seconds = strtotime($date);
           $difference = $time_seconds - 28800;
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
           $new_transaction->admin_share = $admin_share;
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
   
          
           //deducting from wallet
           $wallet_balance = $this->userDetails()->wallet;
           $new_wallet_balance = $wallet_balance - $user_charge;
   
           //updating wallet balance 
           User::findOrFail(session()->get("loggedUser"))->update([
             "wallet" => $new_wallet_balance
           ]);
     
   
             $transaction_data = array(
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
         
   
           return redirect()->to("/waecpinsuccess");
         
   
       }else{
        
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
           return view("users.dashboard.education.waecpinsuccess")->with("transaction_data",$transaction_data);
         }
      
     }
 
 
 
     
 
 
 
 
 
 
 
 
     public function checkId(){
       $url = "https://sandbox.vtpass.com/api/services?identifier=electricity-bill";
       $response = $this->makeGetRequest($url);
       dd($response);
     }
}
