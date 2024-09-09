<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\Activities;
use App\Models\VtpassTransactions;
use App\Models\AdminEarnings;
use App\Models\States;
use App\Models\BusinessDetails;
use App\Models\VirtualAccounts;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
     public function login(Request $request){
        if($request->has("admin_login_btn")){
            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            $admin = Admin::where("email","=",$request->email)->where('role',"=",'admin')->first();
            if($admin){
                if(Hash::check($request->password,$admin->password)){
                    session()->put("loggedAdmin",$admin->id);
                    return redirect()->to("/dashboard");
                }else{
                    return redirect()->back()->with('error',"invalid admin password");
                }
            }else{
                return redirect()->back()->with("error","invalid admin email");
            }
        }else{
            return redirect()->to("/");
        }
     }




     public function createAdmin(){
        $admin = new Admin();
        $admin->email = "dropifyadmin@gmail.com";
        $admin->password = Hash::make("admin123");
        $admin->role = 'admin';
        $admin->save();
        echo "done";
     }



     public function dashboard(){

      
        $total_users = User::where("status","!=","registered")->count();
        $total_transactions = Activities::count();
        $admin_earnings = AdminEarnings::sum("amount");
        $users_transactions = Activities::sum("amount");

        return view("dashboard")->with("total_users",$total_users)
        ->with("total_transactions",$total_transactions)
        ->with("admin_earnings",$admin_earnings)
        ->with("users_transactions",$users_transactions);
    }


    
    public function account(){
        $admin = Admin::find(session()->get("loggedAdmin"));
        return view("account")->with("admin",$admin);
    }
  
  
  
    Public function resetAccount(Request $request){
        if($request->has("reset_account_btn")){
            if(!$request->filled("email") && !$request->filled("password")){
              return redirect()->back()->with("error","You did not fill and field to update");
            }else{
              $id = $request->admin_id;
  
              if($request->filled('email')){
                Admin::find($id)->update([
                  "email" => $request->email
                ]);
  
              }
  
              if($request->filled("password")){
                Admin::find($id)->update([
                  "password" => Hash::make($request->password)
                ]);
  
              }
  
              return redirect()->back()->with("success","Admin details updated successfully");
            }
        }else{
            return redirect()->to('/admin');
        }
    }
  




    public function logout(){
        session()->pull("loggedAdmin");
        return redirect()->to("/");
    }




    public function register(){
      $states = States::get();
      return  view("register.register")->with("states",$states);
    }


    public function store(Request $request){
        if($request->has("register_agent_btn")){
            $ip_address = $request->ip();
            $request->validate([
                "email" => "required|email:unique:users",
                "phone" => "required|unique:users",
                "state" => "required",
                "city" => "required",
                "address" => "required",
                "profile_image" => "required|mimes:png,jpeg,jpg,jiff|max:3000",
                "BVN" => "required",
                "NIN" => "required",
                "password" => [
                 'required',
                 Password::min(8)->letters()->numbers()->mixedCase()->symbols()
    
                ]
            ]);

            if($request->hasFile("profile_image") && $request->file('profile_image')->isValid()){
                $image = $request->file("profile_image");
                $image_with_ext = $image->getClientOriginalName();
                $image_ext = $image->getClientOriginalExtension();
                $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
                $image_to_store = $image_only . "_" . time() . "." . $image_ext;
                $storage_path = $image->storeAs("public/users",$image_to_store);
            }else{
                return redirect()->back()->with("error","please upload an image of right specifications");
            }
            
            
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
      
       "account_name" => $request->fullname,
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
    return redirect()->back()->with("error","Virtual Account Could not be created");
}

            $user = new User();
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->address = $request->address;
            $user->BVN = $request->BVN;
            $user->NIN = $request->NIN;
            $user->ip_address = $ip_address;
            $user->profile_image = "storage/users/".$image_to_store;
            $user->password = Hash::make($request->password);
            $user->pos_serial_number = $request->pos_serial_number;
            $user->status = "active";
            $user->save();
             $latest_user = User::orderBy('id',"desc")->where('status',"=","active")->where('email',"=",$request->email)->first();
             
              
              $virtual_account = new VirtualAccounts();
              $virtual_account->user_id = $latest_user->id;
              $virtual_account->account_name = $account_name;
              $virtual_account->account_number = $account_number;
              $virtual_account->bank_name = $bank;
              $virtual_account->bank_code = $account_reference;
              $virtual_account->save();
             
             
             session()->put("user_id",$latest_user->id);
             return redirect()->to("/agentbusinessdetails");
        }else{
            return redirect()->to("/");
        }
    }


    public function businessDetails(){
        if(!session()->has("user_id")){
            return redirect()->to("/register");
        }else{
            $user_id = session()->get("user_id");
            $user = User::find($user_id);
            return view('register.business_details')->with("user_id",$user_id)->with("user",$user);
        }
    }



    public function saveBusinessDetails(Request $request){
        $request->validate([
            "business_name" => "required|unique:business_details",
            "CAC_certificate" => "required|mimes:pdf,png,jpeg,jpg|max:3000",
            "RC_number" => "required",
            "user_id" => "required"
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
          if($request->filled("RC_number")){
            $business->RC_number = $request->RC_number;
          }

           $business->save();

           session()->pull("user_id");
           return redirect()->to("register")->with("success","Account Created Successfully,You will be notified once your details has been confirmed by Dropifypay");

          }else{
            return redirect()->back()->with("error","please upload CAC certificate image with right specifications");
          }

    }
}
