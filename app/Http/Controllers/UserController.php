<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\States;
use App\Models\BusinessDetails;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Suporrt\Facades\Storage;
use App\Models\Activities;
use App\Models\Transfers;
use App\Models\Withdrawals;
use App\Models\Deposits;
use App\Models\VirtualAccounts;
use App\Models\Agreegator;



class UserController extends Controller
{
    public function index(){
        if(session()->get("section") == "agreegator"){
            session()->pull("section");
            session()->put("section","agent");
        }else{
            session()->put("section","agent");
        }
        $users = User::where("status","=","active")->where("Mapping_status","=","mapped")->paginate(30);
        return view("users.index",compact("users"));
    }

    public function suspendAgent(Request $request){
        if($request->has("suspend_user_btn")){
            User::find($request->agent_id)->update([
                "status" => 'suspended',
            ]);
        }else{
            return redirect()->to("/");
        }
       

        return redirect()->back()->with('success',"agent suspended suspended successfully");
    }



    public function searchUser(Request $request){
        $term = $request->term;
        $users = User::where('status',"=","active")->where("fullname","like","%{$term}%")->get();
        return view("users.namesearch")->with("users",$users);
    }


    public function unactivatedAgents(){
        $users = User::where('status',"=","registered")->orderBy("id","desc")->get();
        return view("users.unactivated_users")->with("users",$users);
    }


    public function upmappedAgents(){
        $users = User::where('status',"=","active")->where("Mapping_status","=","unmapped")->get();
        return view("users.unmapped_users")->with("users",$users); 
    }


    public function create(){
        $states = States::get();
        return view("users.create")->with('states',$states);
    }



    public function store(Request $request){
        if($request->has("create_user_btn")){
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
                "pos_serial_number" => "required|unique:users",
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
             return redirect()->to("/businessdetails");
        }else{
            return redirect()->to("/");
        }
    }


    public function businessDetails(){
        if(!session()->has("user_id")){
            return redirect()->to("/");
        }else{
            $user_id = session()->get("user_id");
            $user = User::find($user_id);
            return view('users.businessdetails')->with("user_id",$user_id)->with("user",$user);
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
           return redirect()->to("createuser")->with("success","agent created successfully");

          }else{
            return redirect()->back()->with("error","please upload CAC certificate image with right specifications");
          }

    }



    public function activateUser(Request $request){
        if($request->has('activate_user_btn')){
            User::find($request->user_id)->update([
                "status" => "active"
            ]);
            return redirect()->to("/unactivatedagents")->with("success","user activated successfully");
        }else{
            return redirect()->to("/");
        }
    }





   public function mapAgent($id){
       $user = User::find($id);
       return view("users.serial_number")->with("user",$user);
   }

    public function processAgentMapping(Request $request){
        if($request->has('map_agent_btn')){
            $request->validate([
                "pos_serial_number" => "unique:users"
                ]);
            User::find($request->user_id)->update([
                "pos_serial_number" => $request->pos_serial_number,
                "Mapping_status" => "mapped"
            ]);
            return redirect()->to("/unmappedagents")->with("success","user Mapped successfully");
        }else{
            return redirect()->to("/");
        }
    }



    public function unmapAgent(Request $request){
        if($request->has('unmap_agent_btn')){
          
            User::find($request->agent_id)->update([
                "pos_serial_number" => null,
                "Mapping_status" => "unmapped"
            ]);
            return redirect()->to("/agents")->with("success","user unMapped successfully");
        }else{
            return redirect()->to("/");
        }
    }


    public function suspendAccount(Request $request){
        if($request->has('suspend_user_btn')){
            User::find($request->user_id)->update([
                "status" => "suspended"
            ]);
            return redirect()->back()->with("success","user suspended successfully");
        }else{
            return redirect()->to("/");
        }
    }


    public function suspendedAgents(){
        $users = User::where("status",'=','suspended')->orderBy("id","desc")->get();
        return view("users.suspended")->with("users",$users);
    }



    public function show($id){
        $user = User::find($id);
        $business_details = BusinessDetails::where("user_id","=",$id)->first();
        $latest_activities = Activities::where('user_id',"=",$id)->orderBy("id","desc")->limit(10)->get();
        $activities_sum = Activities::where('user_id',"=",$id)->sum("amount");
        $activities_count = Activities::where('user_id',"=",$id)->count();
        $deposit_sum = Deposits::where("user_id","=",$id)->sum("amount");
        $withdrawal_sum = Withdrawals::where('user_id',"=",$id)->sum("amount");
        $transfer_sum = Transfers::where("user_id","=",$id)->sum('amount');
        return view("users.show")->with("user",$user)
        ->with("business_details",$business_details)
        ->with("latest_activities",$latest_activities)
        ->with("activities_sum",$activities_sum)
        ->with("deposit_sum",$deposit_sum)
        ->with("withdrawal_sum",$withdrawal_sum)
        ->with("transfer_sum",$transfer_sum)
        ->with("activities_count",$activities_count);
        
    }


    public function edit($id){
        $user = User::find($id);
        $business_details = BusinessDetails::where("user_id","=",$id)->first();
        $states = States::get();
        return view("users.edit")->with("user",$user)
        ->with('states',$states)
        ->with("user_id",$user->id)
        ->with("business_details",$business_details);
    }



    public function updateUser(Request $request){
        if($request->has("update_user_btn")){
            $user = User::find($request->user_id);
            if($request->filled("fullname")){
                User::find($request->user_id)->update([
                    "fullname" => $request->fullname
                ]);
            }

            if($request->filled("email") && $request->email != $user->email){
                $request->validate([
                    "email" => "email|unique:users"
                ]);
                User::find($request->user_id)->update([
                    "email" => $request->email
                ]);
            }



            if($request->filled("phone") && $request->phone != $user->phone){
                $request->validate([
                    "phone" => "min:11|unique:users"
                ]);
                User::find($request->user_id)->update([
                    "phone" => $request->phone
                ]);
            }


            if($request->filled("state")){
                User::find($request->user_id)->update([
                    "state" => $request->state
                ]);
            }


            if($request->filled("city")){
                User::find($request->user_id)->update([
                    "city" => $request->city
                ]);
            }


            if($request->filled("address")){
                User::find($request->user_id)->update([
                    "address" => $request->address
                ]);
            }


            if($request->filled("BVN")){
                User::find($request->user_id)->update([
                    "BVN" => $request->BVN
                ]);
            }



            if($request->filled("NIN")){
                User::find($request->user_id)->update([
                    "NIN" => $request->NIN
                ]);
            }


            if($request->filled("ip_address")){
                User::find($request->user_id)->update([
                    "ip_address" => $request->ip_address
                ]);
            }


            if($request->hasFile("profile") && $request->file("profile_image")){
                $user = User::find($request->user_id);
                $image = $request->file("profile_image");
                $image_with_ext = $image->getClientOriginalName();
                $image_ext = $image->getClientOriginalExtension();
                $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
                $image_to_store = $image_only . "_" . time() . "." . $image_ext;
                $storage_path = $image->storAs("public/users",$image_to_store);
                Storage::delete($user->profile_image);
                User::find($user->id)->update([
                    "profile_image" => "storage/users/".$image_to_store
                ]);
            }


           return redirect()->back()->with('success','user details updated successfully');

        }else{
            return redirect()->to("/");
        }
    }



    public function updateBusinessDetails(Request $request){
        if($request->has("update_business_btn")){
            $business_details = BusinessDetails::where("user_id","=",$request->user_id)->first();
            $id = $business_details->id;
            if($request->filled("business_name")){
                 BusinessDetails::find($id)->update([
                    "business_name" => $request->business_name
                 ]);
            }

            if($request->filled("RC_number")){
                BusinessDetails::find($id)->update([
                    "RC_number" => $request->RC_number
                ]);
            }


            if($request->hasFile("CAC_certificate") && $request->file("CAC_certificate")->isValid()){

                $image = $request->file("CAC_certificate");
                $image_with_ext = $image->getClientOriginalName();
                $image_ext = $image->getClientOriginalExtension();
                $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
                $image_to_store = $image_only . "_" . time() . "." . $image_ext;
                $storage_path = $image->storeAs("public/CAC",$image_to_store);

                Storage::delete("$business_details->CAC_certificate");
                BusinessDetails::find($id)->update([
                    "CAC_certificate" => "storage/CAC/". $image_to_store
                ]);
    
              }


              return redirect()->back()->with("success","Business details updated successfully");
          
               
        }else{
            return redirect()->to("/");
        }
    }




     public function addAgreegator($id){
        $user = User::find($id);
        $agreegators = Agreegator::get();
         if(count($agreegators) == 0){
            return redirect()->back()->with('error',"no agreegators yet");
         }
        return view("users.add_agreegator")->with("agreegators",$agreegators)->with("user",$user);
     }


     public function saveUserAgreegator(Request $request){
        User::find($request->agent_id)->update([
            "agreegator_id" => $request->agreegator_id
        ]);
        return redirect()->to("/agents")->with('success',"agreegator added successfully");
     }



     public function removeAgreegator(Request $request){
      User::find($request->agent_id)->update([
        "agreegator_id" => 0
      ]);

      return redirect()->back()->with("success","agreegator removed successfully");
     }


     public function agentWallet($id){
        $user = User::find($id);
        return view("users.manage_wallet")->with("user",$user);
     }


     public function manageAgentWallet(Request $request){
        $user = User::find($request->agent_id);
        $transaction = $request->transaction_type;
        if($transaction == "credit"){
            User::find($user->id)->update([
                "wallet" => ($user->wallet + $request->amount)
            ]);
        }else if($transaction == "debit"){
            if($user->wallet < $request->amount){
                return redirect()->back()->with("error","agent balance is less than debit amount");
            }else{
                User::find($user->id)->update([
                    "wallet" => ($user->wallet - $request->amount)
                ]);
            }
        }

        return redirect()->to("/agents")->with("success","wallet updated successfully");
     }


    public function agentActivities($id){
        $activities = Activities::where("user_id","=",$id)->orderBy("id","desc")->paginate(30);
        $total = Activities::where("user_id","=",$id)->sum("amount");
        $user = User::find($id);
        return view("users.agentactivities")->with('activities',$activities)->with("total",$total)->with("data",$user->fullname)->with("id",$user->id);
    }


    public function agentDeposits($id){
        $user = User::find($id);
        $deposits = Deposits::where("user_id","=",$id)->orderBy("id","desc")->get();
        $total = Deposits::where("user_id","=",$id)->sum("amount");
        return view("users.agentdeposits")->with("deposits",$deposits)->with("total",$total)->with("data",$user->fullname)->with("id",$user->id);

    }


    public function agentWithdrawals($id){
        $user = User::find($id);
        $withdrawals = Withdrawals::where("user_id","=",$id)->orderBy("id","desc")->paginate(30);
        $total = Withdrawals::where("user_id","=",$id)->sum("amount");
        return view("users.agentwithdrawals")->with("withdrawals",$withdrawals)->with("total",$total)->with("data",$user->fullname)->with("id",$user->id);

    }



    public function agentTransfers($id){
        $user = User::find($id);
        $transfers = Transfers::where("user_id","=",$id)->orderBy("id","desc")->paginate(30);
        $total = Transfers::where("user_id","=",$id)->sum("amount");
        return view("users.agenttransfers")->with("transfers",$transfers)->with("total",$total)->with("data",$user->fullname)->with("id",$user->id);

    }




}
