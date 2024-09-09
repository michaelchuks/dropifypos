<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activities;
use App\Models\Transfers;
use App\Models\Deposits;
use App\Models\Withdrawals;
use App\Models\VtpassTransactions;
use App\Models\ElectricityTokens;
use App\Models\AdminEarnings;



class DashboardController extends Controller
{
    
public function sampleRequest(){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://dropifypay.com.ng/api/flutterwavenotification',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('responseMessage' => '','amount' => '3500','cardholder' => 'SHOLANKE/LATEEF','cardscheme' => 'MASTER CARD','currencycode' => 'NGN','customername' => 'SHOLANKE/LATEEF','expiry' => '220531','pan' => '539983******5635','responsecode' => '00','responsemessage' => 'APPROVED','rrn' => '574840094501','stan' => '420430','terminalid' => '98230408902915','type' => 'PURCHASE','serialNumber' => '100449097','field1' => '','field2' => '','field3' => ''),
  CURLOPT_HTTPHEADER => array(
"Authorization: Bearer tKqa2SqrVVLBLePncEDprwMLZKwwjc4HSPvcZIt33dd4c9b4"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
dd(json_decode($response,true));
  
    }
    
    
    
   
    
    
    
    
    
    
    
    
    public function activities(){
        $activities = Activities::with(["vtuTransaction"])->where("user_id","=",auth()->user()->id)->orderBy('id',"desc")->paginate(20);
        return response()->json([
            "status" => true,
            "activities" => $activities
            ]);
    }
    
    
    
    public function activity($id){
        $activity = Activities::find($id);
        if($activity->api_platform == "transfer"){
        $transaction_details = Transfers::find($activity->platform_table_id);
             return response()->json([
            "status" => true,
            "activity" => $activity,
            "transaction_data" => $transaction_details
            ]);
            
        }else if($activity->api_platform == "vtpass"){
            $transaction_details = VtpassTransactions::find($activity->platform_table_id);
            if($transaction_details->transaction_type == "electricity"){
             $meter_recharge_details = ElectricityTokens::where("platform_table_id","=",$transaction_details->id)->first();
             return response()->json([
            "status" => true,
            "activity" => $activity,
            "transaction_data" => $transaction_details,
            "meter_recharge_details" => $meter_recharge_details
            ]);
            }else{
             return response()->json([
            "status" => true,
            "activity" => $activity,
            "transaction_data" => $transaction_details
            ]);
            }
        }else if($activity->api_platform == "withdrawal"){
            $transaction_details = Withdrawals::find($activity->platform_table_id);
            return response()->json([
            "status" => true,
            "activity" => $activity,
            "transaction_data" => $transaction_details
            ]);
        }
       
    }
    
    
    public function transfers(){
        $transfers = Transfers::where("user_id","=",auth()->user()->id)->orderBy("id","desc")->get();
        return response()->json([
            "status" => true,
            "transfers" => $transfers
            ]);
    }
    
    
    
      public function deposits(){
        $deposits = Deposits::where("user_id","=",auth()->user()->id)->orderBy("id","desc")->get();
        return response()->json([
            "status" => true,
            "deposits" => $deposits
            ]);
    }
    
    
    
    public function flutterwaveNotification(Request $request){
        /* $request->validate([
             "cardholder" => "required",
             "cardscheme" => "required",
             "customername" => "required",
             "responsemessage" => "required",
             "amount" => "required",
             "rrn" => "required",
             "responsecode" => "required",
             "stan" => "required",
             "terminalid" => "required",
             "serialNumber" => "required",
             "type" => "required"
             ]);*/
             
             
             $validator = Validator::make($request->all(),[
                  "cardholder" => "required",
             "cardscheme" => "required",
             "customername" => "required",
             "responsemessage" => "required",
             "amount" => "required",
             "rrn" => "required",
             "responsecode" => "required",
             "stan" => "required",
             "terminalid" => "required",
             "serialNumber" => "required",
             "type" => "required"
                 ]);
             
             if($validator->fails()){
                 $errors = $validator->errors();
                 return response()->json(
                     [
                         'errors' => $errors
                         ],404);
             }
             
             //checking for serial no
             
         $check_serial_no = User::where("pos_serial_number","=",$request->serialNumber)->first();
         if(!$check_serial_no){
             return response()->json([
                 "status" => false,
                 "message" => "invalid serial no"
                 ]);
         }
             
          mail("michaelchuks40@gmail.com","transaction notification","a transaction from dropifypay pos");
          
           $card_holder = $request->cardholder;
           $card_scheme = $request->cardscheme;
           $customer_name = $request->customername;
           $response_message = $request->responsemessage;
           $amount = $request->amount;
           $rrn = $request->rrn;
           $response_code = $request->responsecode;
           $stan = $request->stan;
           $terminal_id = $request->terminalid;
           $serial_no = $request->serialNumber;
           $type = $request->type;
           
           //checking for transaction uniqueness
           $transaction_check = Withdrawals::where("terminal_id","=",$terminal_id)->where("rrn","=",$rrn)->where("stan","=",$stan)->where('amount',"=",$amount)->first();
           if($transaction_check){
                mail("michaelchuks40@gmail.com","double transaction","a transaction with stan $stan and rrn $rrn and amount of $amount has been recoreded earlier");
           }else{
               //checking transaction_type;
               if($response_code == "00" && $type == "PURCHASE"){
                   if($amount < 20000){
                       $charge = (0.005 * $amount);
                   }else{
                       $charge = 100;
                   }
                   //getting the ownere of the transaction
                   $user = User::where("pos_serial_number","=",$request->serialNumber)->first();
                   
                   //inserting into the withdrawals table
                   $withdrawal = new Withdrawals();
                   $withdrawal->user_id = $user->id;
                   $withdrawal->card_holder = $card_holder;
                   $withdrawal->card_scheme = $card_scheme;
                   $withdrawal->customer_name = $customer_name;
                   $withdrawal->response_message = $response_message;
                   $withdrawal->amount = $amount;
                   $withdrawal->charge = $charge;
                   $withdrawal->rrn = $rrn;
                   $withdrawal->response_code = $response_code;
                   $withdrawal->stan = $stan;
                   $withdrawal->terminal_id = $terminal_id;
                   $withdrawal->serial_no = $serial_no;
                   $withdrawal->save();
                   
                   $latest_withdrawal = Withdrawals::where("user_id","=",$user->id)->orderBy("id","desc")->first();
                   
                   
                   //inserting into the activities table
                     $data = strtotime(date("Y-m-d"));
             $week = date("W", $data);
             $day = date("d",$data);
               $activity = new Activities();
               $activity->user_id = $user->id;
               $activity->transaction_type = "debit";
               $activity->activity_type = "withdrawal";
               $activity->amount = $amount;
               $activity->api_platform = "withdrawal";
               $activity->day = $day;
               $activity->week = $week;
               $activity->platform_table_id = $latest_withdrawal->id;
               $activity->month = date("F");
               $activity->year = date("Y");
               $activity->save();
                   
                   
                   //deducting the charge
                   User::find($user->id)->update([
                       "wallet" => ($user->wallet - $charge)
                       ]);
                       
                  //inserting into admin earning
                  $admin_earning = new AdminEarnings();
                  $admin_earning->user = $user->id;
                  $admin_earning->activity = "withdrawal";
                  $admin_earning->amount = $charge;
                  $admin_earning->save();
                  
                  mail("michaelchuks40@gmail.com","Successful transaction","a transaction with stan $stan and rrn $rrn and amount of $amount has been carried out by $user->fullname and recoreded");
                  
                   
               }else if($response_code == "RV00" && $type == "REVERSAL"){
                   mail("michaelchuks40@gmail.com","reverse transaction","a transaction with stan $stan and rrn $rrn and amount of $amount has been reversed to $user->fullname");
               }
           }
           
           
            return response()->json([
                "status" => true,
                "message" => 'webhook processed'
                ]);
         
      
     }
    
    
    
    
    
    
}