<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubAdmin;
use App\Models\SubadminPrivileges;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class SubadminController extends Controller
{
    //

    public function index(){
        $subadmin = SubAdmin::orderBy("id","desc")->get();
        return view("subadmin.index")->with('subadmins',$subadmin);
    }


    public function create(){
        return view("subadmin.create");
    }


    public function store(Request $request){
        $request->validate([
            "email" => "required|unique:sub_admins",
            "password" => "required",
            "image" => "required|max:3000|mimes:jpg,png,jpeg"
        ]);
        if($request->hasFile("image") && $request->file("image")->isValid()){
            $image = $request->file("image");
            $image_with_ext = $image->getClientOriginalName();
            $image_ext = $image->getClientOriginalExtension();
            $image_only = pathinfo($image_with_ext,PATHINFO_FILENAME);
            $image_to_store = $image_only . "_" . time() . "." . $image_ext;
            $storage_path = $image->storeAs("public/subadmin",$image_to_store);
            
         $new_admin = new SubAdmin();
         $new_admin->name = $request->name;
         $new_admin->email = $request->email;
         $new_admin->password = Hash::make($request->passwordd);
         $new_admin->image = $image_to_store;
         $new_admin->save();
         return redirect()->back()->with("success","subadmin created successfully");
        }
    }


    public function delete($id){
        $subadmin = subadmin::find($id);
        Storage::delete("public/subadmin/$subadmin->image");
        subadmin::find($id)->delete();
        return redirect()->back()->with("success","subadmin created successfully");
    }




    public function subadminRoles(){
        $roles = SubadminPrivileges::get();
        return view("subadmin.roles")->with("roles",$roles);
    }

    public function updateSubadminRoles(Request $request){
        $agrregator_roles = SubadminPrivileges::get();
        foreach($agreegator_roles as $role){
            SubadminPrivileges::find($role->id)->update([
                "is_active" => false
            ]);
        }

        foreach($request->roles as $role){
            SubadminPrivileges::find($role)->update([
                "is_active" => true
            ]);
        }

        return redirect()->back()->with("success","Sudamin roles updated successfullly");
    }
}
