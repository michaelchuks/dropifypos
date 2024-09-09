<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionCharges;
use App\Models\minimumWalletBalance;
use App\Models\Admin;
use App\Models\Packages;
use App\Models\SmartRecargeCharges;
use App\Models\SmartRechargeSmeData;
use App\Models\EducationCharges;
use App\Models\Advert;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SettingsController extends Controller
{
    public function transactionCharges(){
        $transaction_charges = TransactionCharges::paginate(30);
        return view("settings.charges")->with("transaction_charges",$transaction_charges);
    }

    public function charge($id){
        $charge = TransactionCharges::find($id);
        return view("settings.charge")->with("charge",$charge);
    }


    public function updateCharge(Request $request){
        if($request->has("update_charge_btn")){
            if(!$request->filled("api_platform") && !$request->filled("transaction_type") && !$request->filled("charge") && !$request->filled("package_type")){
                return redirect()->back()->with("error","you filled not Field to update");
            }else{
               $charge_id = $request->charge_id;
               if($request->filled("api_platform")){
                   TransactionCharges::find($charge_id)->update([
                       "api_platform" => $request->api_platform
                   ]);
               }

               if($request->filled("transaction_type")){
                TransactionCharges::find($charge_id)->update([
                    "transaction_type" => $request->transaction_type
                ]);
            }

            if($request->filled("charge")){
                TransactionCharges::find($charge_id)->update([
                    "charge" => $request->charge
                ]);
            }


            if($request->filled("package_type")){
                TransactionCharges::find($charge_id)->update([
                    "package_type" => $request->package_type
                ]);
            }

                return redirect()->to("/commissions")->with("success","Transaction charge updated successfully");
            }
            
        }else{
            return redirect()->to("/");
        }
    }


      public function newCharge(){
        $packages = Packages::all();
          return view("settings.newcharge")->with("packages",$packages);
      }


      public function saveCharge(Request $request){
          if($request->has("save_charge_btn")){
              $charge = new TransactionCharges();
              $charge->api_platform = $request->api_platform;
              $charge->transaction_type = $request->transaction_type;
              $charge->package_type = $request->package_type;
              $charge->charge = $request->charge;
              $charge->save();
              return redirect()->back()->with("success","charge added successfully");
          }else{
              return redirect()->to("/");
          }
      }



    public function deleteCharge(Request $request){
        if($request->has("delete_charge_btn")){
            TransactionCharges::find($request->charge_id)->delete();
            return redirect()->back()->with("success","Charge Deleted Successfully");
        }else{
           
            return redirect()->to("/");
        }
    }




    public function minimumWalletBalance(){
        $minimum_balance = minimumWalletBalance::orderBy("id","desc")->first();
        return view("settings.minimumbalance")->with("minimum_balance",$minimum_balance);
    }


    public function updateMinimumBalance(Request $request){
        if($request->has("update_balance_btn")){
            minimumWalletBalance::find($request->balance_id)->update([
                "minimum_wallet_balance" => $request->balance
            ]);
            return redirect()->back()->with("success","Minimum balance updated successfully");
        }else{
            return redirect()->to("/");
        }
    }




    public function packages(){
        $packages = Packages::all();
        return view("settings.packages")->with("packages",$packages);
    }


    public function newPackage(){
        return view("settings.newpackage");

    }


    public function savePackage(Request $request){
        if($request->has("save_package_btn")){
            $request->validate([
                "package" => "required",
                "upgrade_amount" => "required",
                "description" => "required",
            ]);

            $package = new Packages();
            $package->package = $request->package;
            $package->upgrade_amount = $request->upgrade_amount;
            $package->description = $request->description;
            $package->save();
            return redirect()->back()->with("success","Package added successfully");
        }else{
            return redirect()->to("/");
        }
    }


    public function package($id){
        $package = Packages::find($id);
        return view("settings.package")->with("package",$package);
    }



    public function updatePackage(Request $request){
        if($request->has("update_package_btn")){
            if(!$request->filled("package") && !$request->filled("upgrade_amount") && !$request->filled("description")){
                return redirect()->back()->with("error","No field was filled for update");
            }else{
                $package_id = $request->package_id;

                if($request->filled("package")){
                    Packages::find($package_id)->update([
                        "package" => $request->package
                    ]);
                }

                if($request->filled("upgrade_amount")){
                    Packages::find($package_id)->update([
                        "upgrade_amount" => $request->upgrade_amount
                    ]);
                }

                if($request->filled("description")){
                    Packages::find($package_id)->update([
                        "description" => $request->description
                    ]);
                }

                return redirect()->back()->with("success","package details updated successfully");
            }
        }else{
            return redirect()->to("/");
        }
    }



    public function deletePackage(Request $request){
        if($request->has("delete_package_btn")){
            Packages::find($request->package_id)->delete();
            return redirect()->back()->with("success","package deleted successfully");
        }else{
            return redirect()->to("/");
        }
    }






    public function smartRechargeCharges(){
        $charges = SmartRecargeCharges::paginate(30);
        return view("settings.smartrechargecharges")->with("charges",$charges);
    }



    public function smartCharge($id){
        $charge = SmartRecargeCharges::find($id);
        $packages = Packages::all();
        return view("settings.smartcharge")->with("charge",$charge)->with("packages",$packages);
    }


    public function updateSmartCharge(Request $request){
        if($request->has("update_charge_btn")){
            if(!$request->filled("original_charge") && !$request->filled("user_charge")){
                return redirect()->back()->with("error","you filled not Field to update");
            }else{
               $charge_id = $request->charge_id;
               if($request->filled("original_charge")){
                SmartRecargeCharges::find($charge_id)->update([
                       "original_charge" => $request->original_charge
                   ]);
               }

               if($request->filled("user_charge")){
                SmartRecargeCharges::find($charge_id)->update([
                    "user_charge" => $request->user_charge
                ]);
            }

           
                return redirect()->to("/smartcharges")->with("success","Transaction charge updated successfully");
            }
            
        }else{
            return redirect()->to("/");
        }
    }


      public function newSmartCharge(){
          $smart_services = SmartRechargeSmeData::all();
        $packages = Packages::all();
          return view("settings.newsmartcharge")->with("packages",$packages)
          ->with('smart_services',$smart_services);
      }


      public function saveSmartCharge(Request $request){
          if($request->has("save_charge_btn")){
              $charge = new SmartRecargeCharges();
              $charge->product_name = $request->product_name;
              $charge->network = $request->network;
              $charge->package_type = $request->package_type;
              $charge->original_charge = $request->original_charge;
              $charge->user_charge = $request->user_charge;
              $charge->save();
              return redirect()->back()->with("success","charge added successfully");
          }else{
              return redirect()->to("/");
          }
      }



    public function deleteSmartCharge(Request $request){
        if($request->has("delete_charge_btn")){
            SmartRecargeCharges::find($request->charge_id)->delete();
            return redirect()->back()->with("success","Charge Deleted Successfully");
        }else{
           
            return redirect()->to("/");
        }
    }



   public function educationCharges(){
    $charges = EducationCharges::orderBy("id","desc")->first();
    return view("settings.educationcharges")->with('charges',$charges);
   }


   public function updateEducationCharges(Request $request){
    $charges = EducationCharges::orderBy("id","desc")->first();
     if($request->filled("waec")){
        EducationCharges::find($charges->id)->update([
            "waec" => $request->waec
        ]);
     }

     if($request->filled("jamb")){
        EducationCharges::find($charges->id)->update([
            "jamb" => $request->jamb
        ]);
     }

    }
    
    
    public function generateAccessToken(){
        $user = User::where("email","=","dropifyadmin@gmail.com")->first();
        $token = $user->createToken("flutterwave-token", ['*'],now()->addWeek(52))->plainTextToken;
        dd($token);
        
    }

}
