<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfers;
use App\Models\User;
use App\Models\Activities;
use App\Models\AdminEarnings;
use App\Models\Admin;

class TransferController extends Controller
{
    
public $base_url = "https://sagecloud.ng/api";
public $public_key = "SCPub-L-056332da5ca9482a8e4d4d5d51ba8811";
public $secret_key = "SCSec-L-5dc2f29d25ca4c178d71485e4038ad8e";
public $encription_key = "7a93faba46c84fd181e7fdccbecfb8345810720a987943218d5c402ee521bbf8";
public $initialization_vector = "a60dabe5f8f244fa";
public $webhook_signature = "a60dabe5f8f244fa";
public $webhook_file = "confirm_transfer.php";
public $test_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiZDZhOWIzZTkxMWQ0NjY1MjI0YzQxODRkZDFjNDdkZGVhY2ExNjFlNzVkNjdhM2U1ZTBhNDgzMDg2YzYxNGQ4ZmY4ZWQyZDc5ZWE5ZGM4YTciLCJpYXQiOjE3MjIxMTY3MTguMDM3NzMxLCJuYmYiOjE3MjIxMTY3MTguMDM3NzM0LCJleHAiOjE3MjIyMDMxMTguMDIwOTU3LCJzdWIiOiI2MDkiLCJzY29wZXMiOlsiKiJdfQ.OBM9CXBlQ0D2RhzFdj_kNTwkO56PpzB63vCFWqxkQ0KokKIGkEa9AfFbk2XTEmEVNyC-LMzEunM6vaXafz0m61QLgVt4VUxXZblyneqNveRRn0KrTbmkfCpeaXuHdX22rY0zCz1zUsXqTon4yH9hLQgpp6ZGl9KQmo46drVDutLZlmhHR29YfqJp-9ew97_eEigdjlqLYes0W8TKXb_XN77r8j11gXmtXRmwI6hAhLX3dCj1BT7NFnuplhi4Yg2MZwphkv5zdxJYh0joSHcnKCi-oZHTk11IHey9pyRMCy6bX9ta3omfgRuN49AjTku31AAIb5BADFEBbCGJrX1ICYTe0unHkMdS7ogJuEgavfPwEP2i1F-Tr7PgEgN4Pb78fT1xgDqz8LiMeQfFTAqyveT5FKoc0RhKKxdinww9hBx6F_DTKvvrL1TP4MxCnE8SucmhuUbwq142_xuRdOhdCeT_NXCO2rdGmjL0EprdQ8oMRqv4HthWBFRVttnVqAwfj-gFQOkaUwhHSJqLAdhUaBsG8HfYSoB5IAlWhllje-hvjydhRuOWBQ588E27-RYN9oxkHjMGL44jQl0IlkRtgYJFf-pvxcWGna_5_wA5vFuXknYcgmokPQmzYuPjcLLPq0iAEwV9F8iu3C7p6IfsMdls9K7vK2psbLb8DHstFqs";


public function ercasLogin(){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url/v2/merchant/authorization",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
	"email":"dropifypay@gmail.com",
	"password":"Prinbhobhoangel24###"
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$result = json_decode($response,true);
$status = $result["success"];
if($status == true){
  $token = $result["data"]["token"]["access_token"];
  return response()->json([
    "status" => true,
    "token" => $token
  ]);
}else{
  return response()->json([
    "status" => false,
    "message" => "transfer could not be initiated"
  ]);
}

    }



public function getBanks($token){
//$token = $request->token;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url/v2/transfer/get-transfer-data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$result = json_decode($response,true);
$success = $result["success"];
if($success == true){
    return response()->json([
        "status" => true,
        "banks" => $result["banks"],
        
        ]);
}


    }



public function verifyAccount(Request $request){
    $token = $request->token;
    $account_number = $request->account_number;
    $bank_code = $request->bank_code;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url/v2/transfer/verify-bank-account",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode([
       "bank_code" => $bank_code,
    "account_number" => $account_number
      ]),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response,true);
$success = $result["success"];
if($success == true){
    return response()->json([
        "status" => true,
        "account_name" => $result["account_name"]
        ]);
}else{
    return response()->json([
        "status" => "false",
        "message" => "invalid account number"
        ]);
}
}



public function processTransfer(Request $request){
  
    $request->validate([
        "token" => "required",
        "amount" => "required",
        "bank_name" => "required",
        "account_number" => "required",
        "account_name" => "required",
        "bank_code" => "required",
        "narration" => "required"
        ]);
        
      
 $token = $request->token;     
        
$user = User::find(auth()->user()->id);
$total_amount = $request->amount + 20;
if($user->wallet < $total_amount){
    return response()->json([
        "status" => false,
        "message" => "insufficient wallet balance to process transfer"
        ]);
}
    
$token = $request->token;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url/v2/transfer/fund-transfer",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode([
      "reference" => time(),
    "bank_code" => $request->bank_code,
    "account_number" => $request->account_number,
    "account_name" => $request->account_name,
    "amount" => $request->amount,
    "narration" => $request->narration
      ]),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$result = json_decode($response,true);
//return $result;
$success = $result["success"];
$status = $result["status"];
if($success == true && $status == "success"){
    
    //deduct from user wallet
    User::find($user->id)->update([
        "wallet" => ($user->wallet - $total_amount)
        ]);
        
    //inserting into the transfer table
    $transfer = new Transfers();
    $transfer->user_id = auth()->user()->id;
    $transfer->account_number = $request->account_number;
    $transfer->account_name = $request->account_name;
    $transfer->bank = $request->bank_name;
    $transfer->bank_code = $request->bank_code;
    $transfer->amount = $request->amount;
    $transfer->transaction_charge = 20.0;
    $transfer->reference = time();
    $transfer->status = 'successful';
    $transfer->save();
    
    $latest_transfer = Transfers::where("user_id","=",auth()->user()->id)->where("status",'=',"successful")->orderBy("id","desc")->first();
    
     //inserting into the activity table
            $data = strtotime(date("Y-m-d"));
            $week = date("W", $data);
            $day = date("d",$data);
            $activity = new Activities();
            $activity->user_id = auth()->user()->id;
            $activity->transaction_type = "debit";
            $activity->activity_type = "transfer";
            $activity->amount = $request->amount;
            $activity->api_platform = "transfer";
            $activity->day = $day;
            $activity->week = $week;
            $activity->platform_table_id = $latest_transfer->id;
            $activity->month = date("F");
            $activity->year = date("Y");
            $activity->save();
            
        $admin = Admin::first();
        $admin_balance = $admin->wallet;
        $new_admin_balance = $admin_balance + 20;
        Admin::find($admin->id)->update([
            "wallet" => $new_admin_balance
        ]);
            
     
        $admin_earning = new AdminEarnings();
        $admin_earning->user = $user->fullname;
        $admin_earning->activity = "transfer";
        $admin_earning->amount = 20;
        $admin_earning->save();
    
    return response()->json([
        "status" => true,
        "message" => "transfer processed successfully",
        "amount" => $total_amount
        ]);
    
    
}else{
    return response()->json([
        "status" => false,
        "message" => "transfer cant be processed at the moment"
        ]);
}

}

}
