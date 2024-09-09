<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agreegator;
use App\Models\AgreegatorRoles;
use App\Models\SubadminPrivileges;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Activities;
use App\Models\User;
use App\Models\AgreegatorEarnings;
use App\Models\AgreegatorTranactionShares as AgreegatorTransactionShares;


class AgreegatorController extends Controller
{
    public function index(){
        $agreegator = Agreegator::orderBy("id","desc")->get();
        return view("agreegator.index")->with('agreegators',$agreegator);
    }


    public function create(){
        return view("agreegator.create");
    }


    public function store(Request $request){
        $request->validate([
            "email" => "required|unique:agreegators",
            "password" => "required",
            "image" => "required|max:3000|mimes:jpg,png,jpeg"
        ]);
        if($request->hasFile("image") && $request->file("image")->isValid()){
            $image = $request->file("image");
            $image_with_ext = $image->getClientOriginalName();
            $image_ext = $image->getClientOriginalExtension();
            $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
            $image_to_store = $image_only . "_" . time() . "." . $image_ext;
            $storage_path = $image->storeAs("public/agreegators",$image_to_store);
            
         $new_admin = new Agreegator();
         $new_admin->name = $request->name;
         $new_admin->email = $request->email;
         $new_admin->password = Hash::make($request->passwordd);
         $new_admin->image = $image_to_store;
         $new_admin->save();
         return redirect()->back()->with("success","agreegator created successfully");
        }
    }


    public function delete($id){
        $agreegator = Agreegator::find($id);
        Storage::delete("public/agreegators/$agreegator->image");
        Agreegator::find($id)->delete();
        return redirect()->back()->with("success","agreegator created successfully");
    }


    public function agreegatorRoles(){
        $roles = AgreegatorRoles::get();
        return view("agreegator.roles")->with("roles",$roles);
    }

    public function updateAgreegatorRoles(Request $request){
        $agrregator_roles = AgreegatorRoles::get();
        foreach($agreegator_roles as $role){
            AgreegatorRoles::find($role->id)->update([
                "is_active" => false
            ]);
        }

        foreach($request->roles as $role){
            AgreegatorRoles::find($role)->update([
                "is_active" => true
            ]);
        }

        return redirect()->back()->with("success","agreegator roles updated successfullly");
    }



    public function agreegatorWallet($id){
        $agreegator = Agreegator::find($id);
        return view("agreegator.agreegator_wallet")->with("agreegator",$agreegator);
    }


    public function manageAgreegatorWallet(Request $request){
        $transaction = $request->transaction_type;
        $agreegator = Agreegator::find($request->agreegator_id);
        if($transaction == "credit"){
            Agreegator::find($agreegator->id)->update([
                "wallet" => ($agreegator->wallet + $request->amount)
            ]);
        }else if($transaction == "debit"){
            if($agreegator->wallet < $request->amount){
                return redirect()->back()->with('error',"agreegator wallet balance is less than debit amount");
            }else{
                Agreegator::find($agreegator->id)->update([
                    "wallet" => ($agreegator->wallet - $request->amount)
                ]); 
            }
        }

         return redirect()->to("/agreegators")->with('success',"agreegator wallet updated successfully");
    }


    public function updateAgreegatorStatus(Request $request){
        if($request->has("suspend_agreegator_btn")){
            User::where("agreegator_id","=",$request->agreegator_id)->update([
                "status" => 'suspended'
            ]);
            Agreegator::find($request->agreegator_id)->update([
             "status" => "suspended"
            ]);
            return redirect()->back()->with("success","agreegator suspended successfully");
        }else if($request->has('reactivate_agreegator_btn')){
            User::where("agreegator_id","=",$request->agreegator_id)->update([
                "status" => 'active'
            ]);
            Agreegator::find($request->agreegator_id)->update([
                "status" => "active"
               ]);
               return redirect()->back()->with("success","agreegator reactivated successfully");
        }else{
            return redirect()->to("/");
        }

     
    }


    public function agreegatorAgents($id){
        if(session()->get("section") == "agent"){
            session()->pull("section");
            session()->put("section","agreegator");
        }else{
            session()->put("section","agreegator");
        }
        $agreegator = Agreegator::find($id);
        $users = User::where("agreegator_id","=",$id)->where("status","=","active")->orderBy("id","asc")->paginate(30);
        return view("agreegator.agreegator_agents")->with("users",$users)->with("agreegator",$agreegator);
    }


     public function addAgreegatorAgents($id){
        $agreegator = Agreegator::find($id);
        $users = User::where("agreegator_id","=",0)->where("status",'=',"active")->orWhere("agreegator_id",'=',null)->where("status","=","active")->get();
        return view('agreegator.add_agents')->with("users",$users)->with('agreegator',$agreegator);
     }


     public function assignAgreegatorAgents(Request $request){
        $agents = $request->agents;
        foreach($agents as $agent){
            User::find($agent)->update([
                "agreegator_id" => $request->agreegator_id
            ]);
        }

        return redirect()->to("agreegatoragents/$request->agreegator_id")->with("success","agents added successfully to agreegators");
     }


     public function agreegatorEarnings($id){
        $agreegator = Agreegator::find($id);
        $earnings = AgreegatorEarnings::where("agreegator_id","=",$id)->orderBy("id","desc")->paginate(30);
        return view('agreegator.agreegator_earnings')->with("agreegator",$agreegator)->with("earnings",$earnings);
     }




     public function agreegatorTransactionShares(){
        $transaction_shares = AgreegatorTransactionShares::get();
        return view('agreegator.share_percentage')->with("transaction_shares",$transaction_shares);
     }


     public function updateAgreegatorTransactionShare(Request $request){
        $id = $request->share_percentage_id;
        AgreegatorTransactionShares::find($id)->update([
            "agreegator_percentage" => $request->agreegator_percentage
        ]);

        return redirect()->back()->with("success","agreegator share percentage updated successfully");
     }

  
}
