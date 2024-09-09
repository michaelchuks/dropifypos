<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BusinessDetails;
use App\Models\UserWelcomeEmail;
use App\Models\Userpin;
use App\Models\PasswordRecoveryCodes;
use App\Models\VirtualAccounts;
use App\Mail\LoginOtp;
use App\Models\UserLoginOtp;
use App\Mail\PasswordRecovery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;





class AuthController extends Controller
{    
 public $base_url = "https://sagecloud.ng/api";

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
     return $token;
   }else{
     return false;
   }
   
       }



 public function postRequest($token,$params,$url){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url$url",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => http_build_query($params),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
return json_decode($response,true);

 }






    public function register(Request $request){
        
        $request->validate([
            "name" => "required",
            "email" => "required|email:unique:users",
            "phone" => "required|unique:users",
            "state" => "required",
            "city" => "required",
            "address" => "required",
            "ip_address" => "required",
            "passport" => "required|mimes:png,jpeg,jpg,jiff|max:3000",
            "BVN" => "required",
            "NIN" => "required",
            "password" => [
             'required',
             Password::min(8)->letters()->numbers()->mixedCase()->symbols()

            ]
        ]);

      

 //verifying bvn
 /*
  $token = $this->ercasLogin();
  if($token == false){
    return response()->json([
        "status" => false,
        "message" => "registration cant be processed, please try again later"
    ]);
  }else{
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$this->base_url/v2/kyc/verify-bvn",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "bvn":"22326672161",
    "phone":"07065104694"
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
dd($response);

  }
  //end of verifying bvn
  */

  //verifying nin
  
  
  
  //end of verifying nin
  
   //generating account
  // return $request->email;
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sagecloud.ng/api/v3/virtual-account/generate',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode([
      
       "account_name" => $request->name,
    "email" => $request->email
      
      ]),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: SCSec-L-5dc2f29d25ca4c178d71485e4038ad8e'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$result = json_decode($response,true);
if($result["success"] == true && $result["status"] == "success"){
    $account_number = $result["data"]["account_details"]["account_number"];
    $account_name = $result["data"]["account_details"]["account_name"];
    $bank =  $result["data"]["account_details"]["bank_name"];
    $account_reference =  $result["data"]["account_details"]["account_reference"];
}else{
    return response()->json([
        "status" => false,
        "messaage" => "virtual account creation unsuccessful"
        ]);
}


          if($request->hasFile("passport") && $request->file("passport")->isValid()){
             
               $image = $request->file("passport");
               $image_with_ext = $image->getClientOriginalName();
               $image_ext = $image->getClientOriginalExtension();
               $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
               $image_to_store = $image_only . "_" . time() . "." . $image_ext;
               $storage_path = $image->storeAs("public/users",$image_to_store);
               
             

               $user = new User();
               $user->fullname = $request->name;
               $user->email = $request->email;
               $user->phone = $request->phone;
               $user->state = $request->state;
               $user->city = $request->city;
               $user->address = $request->address;
               $user->BVN = $request->BVN;
               $user->NIN = $request->NIN;
               $user->ip_address = $request->ip_address;
               $user->profile_image = "storage/users/".$image_to_store;
               $user->password = Hash::make($request->password);
               $user->status = "registered";
               $user->wallet = 0;
               $user->save();

               $latest_user = User::where('status','=','registered')->orderBy("id","desc")->first();
              
              $virtual_account = new VirtualAccounts();
              $virtual_account->user_id = $latest_user->id;
              $virtual_account->account_name = $account_name;
              $virtual_account->account_number = $account_number;
              $virtual_account->bank_name = $bank;
              $virtual_account->bank_code = $account_reference;
              $virtual_account->save();

               return response()->json([
                "status" => true,
                "user_id" => $latest_user->id,
                "message" => "registration successfull,please enter business details"
               ]);
          }else{
            return response()->json([
                "status" => false,
                "message" => "upload a valid passport image"
            ]);
          }

        }


        
           public function registerBusiness(Request $request){
            $request->validate([
                "business_name" => "required|unique:business_details",
                "CAC_certificate" => "required|mimes:pdf,png,jpeg,jpg|max:3000",
                "RC_number" => "required"
            ]);

              if($request->hasFile("CAC_certificate") && $request->file("CAC_certificate")->isValid()){

                $image = $request->file("CAC_certificate");
                $image_with_ext = $image->getClientOriginalName();
                $image_ext = $image->getClientOriginalExtension();
                $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
                $image_to_store = $image_only . "_" . time() . "." . $image_ext;
                $storage_path = $image->storeAs("public/CAC",$image_to_store);

              $business = new BusinessDetails();
              $business->user_id = $request->user_id;
              $business->business_name = $request->business_name;
              $business->CAC_certificate = "storage/CAC/". $image_to_store;
              $business->RC_number = $request->RC_number;
               if($request->filled("TIN_number")){
                $business->TIN_number = $request->TIN_number;
              }

               $business->save();
               
               return response()->json([
                   "status" => true,
                   "message" => "registration complete, please wait for account confirmation"
                   ]);

              }else{
                return response()->json([
                    "status" => false,
                    "message" => "upload a valid CAC certificate"
                ]);
              }


              
           }



     
           public function login(Request $request){
             $request->validate([
                "username" => "required",
                "password" => "required"
             ]);

              $user = User::where("email","=",$request->username)->orWhere("phone","=",$request->username)->first();
              if($user){

                if(Hash::check($request->password,$user->password)){
                    if($user->status == "registered"){
                        if(!isset($user->businessDetails->id)){
                            return response()->json([
                                "status" => false,
                                "message" => "user has not uploaded business details and documents"
                            ]);
                        }else{
                            return response()->json([
                                "status" => false,
                                "message" => "your account has not been activated, please exercise patience"
                            ]);
                        }
                    }else if($user->status == "suspended"){
                        return response()->json([
                            "status" => false,
                            "message" => "Your Account has been suspended please contact support"
                        ]);
                    }else if($user->status == "active"){
                          if($user->logged_in == true){
                            return response()->json([
                                "status" => false,
                                "message" => "user already logged in on another device"
                            ]);
                          }else{
                          $otp = rand(111111,666666);
                          Mail::to($user->email)->send(new LoginOtp($user->name,$otp));
                          $new_otp = new UserLoginOtp();
                          $new_otp->user_id = $user->id;
                          $new_otp->otp = $otp;
                          $new_otp->save();
                          return response()->json([
                            "status" => true,
                            "user_id" => $user->id,
                            "message" => "login otp send to user email address"
                          ]);
                          }
                    }
                }else{
                    return response()->json([
                        "status" => false,
                        "message" => "invalid login  password"
                    ]) ;
                }
              }else{
                return response()->json([
                    "status" => false,
                    "message" => "invalid login  phone no or email"
                ]);
              }

           }


public function resendOtp(Request $request){
    $check_otp = UserLoginOtp::where("user_id","=",$request->user_id)->where("status","=","pending")->orderBy("id","desc")->first();
    UserLoginOtp::find($check_code->id)->delete();
    $new_otp = rand(111111,666666);
    $user = User::find($request->user_id);
    Mail::to($user->email)->send(new LoginOtp($user->name,$new_otp));
    $otp = new UserLoginOtp();
    $otp->user_id = $request->user_id;
    $otp->otp = $new_otp;
    $otp->save();
    return response()->json([
        "status" => true,
        "message" => "otp sent to user email"
    ]);
}



public function checkotp(Request $request){
      $request->validate([
        "user_id" => "required",
        "otp" => "required"
      ]);

      $user = User::find($request->user_id);
      $check_otp = UserLoginOtp::where('user_id',"=",$request->user_id)->where("status",'=',"pending")->where("otp","=",$request->otp)->orderBy("id","desc")->first();

    if($check_otp){
        $date = date("Y-m-d:H:i:s");
        $date_seconds = strtotime($date);
        $send_date_seconds = strtotime($check_otp->created_at);
        $difference = $date_seconds  - $send_date_seconds;
        if($difference > 300){
            return response()->json([
                "status" => "false",
                "message" => "otp expired"
            ]);
        }else if($difference < 300){
            UserLoginOtp::find($check_otp->id)->delete();
            $token = $user->createToken("token")->plainTextToken;
            return response()->json([
                "status" => true,
                "token" => $token,
                "user" => $user
            ]);
        }
    }else{
        return response()->json([
            "status" => "false",
            "message" => "invalid otp"
        ]);
    }
}






 public function forgotPassword(Request $request){
    $request->validate([
        "email" => "required|email"
    ]);
    $user = User::where("email","=",$request->email)->first();
    if($user){
        $code = rand(111111,666666);
        $new_code = new PasswordRecoveryCodes();
        $new_code->user_id = $user->id;
        $new_code->code = $code;
        $new_code->save();

        Mail::to($user->email)->send(new PasswordRecovery($user->fullname,$code));
        return response()->json([
            "status" => true,
            "message" => "password recovery code send to user email,code expires after 5 mins",
            "user_id" => $user->id
        ]);

    }else{
        return response()->json([
            "status" => false,
            "message" => "user with email address does not exist"
        ]);
    }
 }


       
 public function resendPasswordCode(Request $request){
    $user_id = $request->user_id;
    $user = User::find($user_id);
    if($user){
       PasswordRecoveryCodes::where("user_id","=",$user_id)->delete();
       $code = rand(111111,666666);
       $new_code = new PasswordRecoveryCodes();
       $new_code->user_id = $user_id;
       $new_code->code = $code;
       $new_code->save();

       Mail::to($user->email)->send(new PasswordRecovery($user->fullname,$code));
       return response()->json([
           "status" => true,
           "message" => "password recovery code send to user email,code expires after 5 mins",
           "user_id" => $user->id
       ]);
    }else{
        return response()->json([
            "status" => false,
            "message" => "invalid user id"
        ]);
    }
    
 }


  public function VerifyCode(Request $request){
    $request->validate([
        "code" => "required",
        "user_id" => "required"
    ]);

     $check_code = PasswordRecoveryCodes::where("user_id","=",$request->user_id)->where("code","=",$request->code)->first();
     if($check_code){
        $send_time = strtotime($check_code->created_at);
        $current_date = strtotime(date("Y-m-d H:i:s"));
        $time_difference = ($current_date - $send_time);
        if($time_difference <= 300){
            return response()->json([
              
                    "status" => true,
                    "message" => "valid code",
                    "user_id" => $request->user_id
                
            ]);
        }else{
             PasswordRecoveryCodes::fins($check_code->id)->delete();
            return response()->json([
                "status" => false,
                "message" => "expired code"
            ]);
        }
     }else{
        return response()->json([
            "status" => false,
            "message" => "invalid code"
        ]);
     }


  }


  public function savePassword(Request $request){
    $request->validate([
      "password" =>   [
            'required',"confirmed",
            Password::min(8)->letters()->numbers()->mixedCase()->symbols()

           ]
    ]);

      User::find($request->user_id)->update([
        "password" => Hash::make($request->password)
      ]);

       return response()->json([
        "status" => true,
        "message" => "password updated successfully"
       ]);


  }
  
  
  public function user(){
      $user = User::find(auth()->user()->id);
      $business_details = BusinessDetails::where("user_id","=",auth()->user()->id)->first();
      return response()->json([
          "status" => true,
          "user" => $user,
          "business_details" => $business_details
          ]);
  }
  
  
  public function updateProfile(Request $request){
      $id = auth()->user()->id;
      $user = User::find($id);
      if($request->filled("fullname")){
           User::find($id)->update([
               "fullname" => $request->fullname
               ]);
      }
      
      
      if($request->filled("email") && $request->email != $user->email){
          $request->validate([
              "email" => "unique:users"
              ]);
           User::find($id)->update([
               "email" => $request->email
               ]);
      }
      
      
       if($request->filled("phone") && $request->phone != $user->phone){
          $request->validate([
              "phone" => "unique:users"
              ]);
           User::find($id)->update([
               "phone" => $request->phone
               ]);
      }
      
      
        
      if($request->filled("state") && $request->state != $user->state){
           User::find($id)->update([
               "state" => $request->state
               ]);
      }
      
      
        if($request->filled("city") && $request->city != $user->city){
           User::find($id)->update([
               "city" => $request->city
               ]);
      }
      
      
        if($request->filled("address") && $request->address != $user->address){
           User::find($id)->update([
               "address" => $request->address
               ]);
      }
      
      return response()->json([
          "status" => true,
          "message" => "user profile updated successfully"
          ]);
     
      
  }
  
  
  
  public function updatePassport(Request $request){
      if($request->hasFile("passport") && $request->file("passport")->isValid()){
           
               $image = $request->file("passport");
               $image_with_ext = $image->getClientOriginalName();
               $image_ext = $image->getClientOriginalExtension();
               $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
               $image_to_store = $image_only . "_" . time() . "." . $image_ext;
               $storage_path = $image->storeAs("public/users",$image_to_store);
               
               User::find(auth()->user()->id)->update([
                   "profile_image" => "storage/users/".$image_to_store
                   ]);
                   
                   return response()->json([
                       "status" => true,
                       "message" => "passport updated successfully"
                       ]);
               
      }
  }
  
  
  
  public function createPin(Request $request){
        $request->validate([
          "pin" => "required"
          ]);
      $pin = Userpin::where("user_id","=",auth()->user()->id)->first();
      if($pin){
          return response()->json([
              "status" => false,
              "message" => "user already created a transaction authorization pin"
              ]);
      }
          
          $pin = new Userpin();
          $pin->user_id = auth()->user()->id;
          $pin->pin = $request->pin;
          $pin->save();
          
          return response()->json([
              "status" => true,
              "message" => "trasaction pin created successfully"
              ]);
  }
  
  
  public function verifyPin(Request $request){
      $pin = Userpin::where("user_id","=",auth()->user()->id)->first();
      if($pin){
          if($request->pin == $pin->pin){
              return response()->json([
                  "status" => true,
                  "message" => "pin is valid"
                  ]);
          }else{
              return response()->json([
                  "status" => false,
                  "message" => "invalid transaction pin"
                  ]);
          }
      }else{
          return response()->json([
              "status" => false,
              "message" => "user has no transaction pin"
              ]);
      }
  }
  
  
  
  public function changePin(Request $request){
      $request->validate([
          "new_pin" => "required",
          "old_pin" => "required"
          ]);
          
          $pin = Userpin::where("user_id","=",auth()->user()->id)->first();
          if($request->old_pin == $pin->pin){
              Userpin::find($pin->id)->update([
                  "pin" => $request->new_pin
                  ]);
                  
                  return response()->json([
                      "status" => true,
                      "message" => "pin updated successfully"
                      ]);
          }else{
              return response()->json([
                  "status" => false,
                  "message" => "old pin is incorrect"
                  ]);
          }
  }
  
  
  public function accountDetails(){
      $account = VirtualAccounts::where("user_id","=",auth()->user()->id)->first();
      return response()->json([
          "status" => true,
          "account_details" => $account
          ]);
  }





         
}

