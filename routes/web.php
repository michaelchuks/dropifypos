<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AuthController as ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\AdminVtpassController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminTransactionsController;
use App\Http\Controllers\AgreegatorController;
use App\Http\Controllers\SubadminController;
use App\Http\Controllers\ErcasController;
use App\Http\Controllers\Api\DashboardController as SampleController;



Route::get('/', function () {
    return view('welcome');
});

Route::get("/register",[ApiController::class,"register"]);
Route::get("/samplerequest",[SampleController::class,"sampleRequest"]);


//ercas
Route::get("/ercas-login",[ErcasController::class,"ercasLogin"]);
Route::get("/ercas-get-banks",[ErcasController::class,"getBanks"]);
Route::get("/register",[AuthController::class,"register"]);
Route::post("/registeragent",[AuthController::class,"store"]);
Route::get("/agentbusinessdetails",[AuthController::class,"businessdetails"]);
Route::post("/saveagentbusinessdetails",[AuthController::class,"saveBusinessDetails"]);
//ercas





Route::get("/banks",[TransferController::class,"getFlutterwaveBanks"]);

Route::name('admin.')->group(function(){
    
     Route::get("/flutterwaveaccesstoken",[SettingsController::class,"generateAccessToken"])->middleware("loggedAdmin");
    
    
    Route::post("adminlogin",[AuthController::class,"login"])->name('login');
    Route::get("/createadmin",[AuthController::class,"createAdmin"]);

    Route::get("/dashboard",[AuthController::class,"dashboard"])->middleware("loggedAdmin");
    Route::get("/agents",[UserController::class,"index"])->name("users.index")->middleware("loggedAdmin");
    Route::get("/unactivatedagents",[UserController::class,"unactivatedAgents"])->middleware("loggedAdmin");
     Route::get("/createuser",[UserController::class,"create"])->name("users.create")->middleware("loggedAdmin");
     Route::get("/suspendedagents",[UserController::class,"suspendedAgents"])->middleware("loggedAdmin");
     Route::post("/saveuser",[UserController::class,"store"])->name("users.store")->middleware("loggedAdmin");
     Route::get("/unmappedagents",[UserController::class,"upmappedAgents"])->middleware("loggedAdmin");
     Route::get("/mapagent/{id}",[UserController::class,"mapAgent"])->middleware("loggedAdmin");
     Route::post("/processagentmapping",[UserController::class,"processAgentMapping"])->middleware("loggedAdmin");
     Route::post("/unmapagent",[UserController::class,"unmapAgent"])->middleware("loggedAdmin");
     Route::get("/addagreegator/{id}",[UserController::class,"addAgreegator"])->middleware("loggedAdmin");
     Route::post("/saveuseragreegator",[UserController::class,"saveUserAgreegator"])->middleware("loggedAdmin");
     Route::post("/removeagreegator",[UserController::class,"removeAgreegator"])->middleware("loggedAdmin");
     Route::get("/agentwallet/{id}",[UserController::class,'agentWallet'])->middleware("loggedAdmin");
     Route::post("/manageagentwallet",[UserController::class,"manageAgentWallet"])->middleware("loggedAdmin");
     Route::get("user/{id}",[UserController::class,"show"])->name("users.show")->middleware("loggedAdmin");
     Route::get("/editprofile/{id}",[UserController::class,"edit"])->name("users.edit")->middleware("loggedAdmin");
     Route::post("/updateagent",[UserController::class,"updateUser"])->name("users.update")->middleware("loggedAdmin");
     Route::post("/updatebusinessdetails",[UserController::class,"updateBusinessDetails"])->name("users.updatebusinessdetails")->middleware("loggedAdmin");
     Route::get("/searchuser",[UserController::class,"searchUser"])->middleware("loggedAdmin");
     Route::get("/businessdetails",[UserController::class,"businessDetails"])->name("users.businessdetails")->middleware("loggedAdmin");
     Route::post("/savebusinessdetails",[UserController::class,"saveBusinessDetails"])->name("users.savebusinessdetails")->middleware("loggedAdmin");
     Route::post("/activateuser",[UserController::class,"activateUser"])->name("users.activate")->middleware("loggedAdmin");
     Route::get("/agenttransactions/{id}",[UserController::class,"agentActivities"])->middleware("loggedAdmin");
     Route::get("/agentdeposits/{id}",[UserController::class,"agentDeposits"])->middleware("loggedAdmin");
     Route::get("/agentwithdrawals/{id}",[UserController::class,"agentWithdrawals"])->middleware("loggedAdmin");
     Route::get("/agenttransfers/{id}",[UserController::class,"agentTransfers"])->middleware("loggedAdmin");
     Route::post("/suspendagent",[UserController::class,'suspendAgent'])->middleware("loggedAdmin");
     
     
     
     //agreegators
     Route::get("/agreegators",[AgreegatorController::class,"index"])->name("agreegator.index")->middleware("loggedAdmin");
     Route::get("/createagreegator",[AgreegatorController::class,"create"])->name("agreegator.create")->middleware("loggedAdmin");
     Route::post("/saveagreegator",[AgreegatorController::class,'store'])->name("agreegator.store")->middleware("loggedAdmin");
     Route::get("/deleteagreegator/{id}",[AgreegatorController::class,"delete"])->name("agreegator.destroy")->middleware("loggedAdmin");
     Route::get("/agreegatorroles",[AgreegatorController::class,"agreegatorRoles"])->middleware("loggedAdmin");
     Route::post("/updateagreegatorroles",[AgreegatorController::class,"updateAgreegatorRoles"])->middleware("loggedAdmin");
     Route::get("/agreegatorwallet/{id}",[AgreegatorController::class,"agreegatorWallet"])->middleware("loggedAdmin");
     Route::post("/manageagreegatorwallet",[AgreegatorController::class,"manageAgreegatorWallet"])->middleware("loggedAdmin");
     Route::post("/updateagreegatorstatus",[AgreegatorController::class,"updateAgreegatorStatus"])->middleware("loggedAdmin");
     Route::get("/agreegatoragents/{id}",[AgreegatorController::class,"agreegatorAgents"])->middleware("loggedAdmin");
    Route::get("/addagreegatoragents/{id}",[AgreegatorController::class,"addAgreegatorAgents"])->middleware("loggedAdmin");
    Route::post("/assignagreegatoragents",[AgreegatorController::class,"assignAgreegatorAgents"])->middleware("loggedAdmin");
    Route::get("/agreegatorearnings/{id}",[AgreegatorController::class,"agreegatorEarnings"])->middleware("loggedAdmin");
    Route::get("/agreegatortransactionshares",[AgreegatorController::class,"agreegatorTransactionShares"])->middleware("loggedAdmin");
    Route::post("/updateagreegatortransactionshare",[AgreegatorController::class,"updateAgreegatorTransactionShare"]);

     //subadmins
     Route::get("/subadmins",[SubadminController::class,"index"])->name("subadmin.index")->middleware("loggedAdmin");
     Route::get("/createsubadmin",[SubadminController::class,"create"])->name("subadmin.create")->middleware("loggedAdmin");
     Route::post("/savesubadmin",[SubadminController::class,'store'])->name("subadmin.store")->middleware("loggedAdmin");
     Route::get("/deletesubadmin/{id}",[SubadminController::class,"delete"])->name("subadmin.destroy")->middleware("loggedAdmin");
     Route::get("/subadminroles",[SubadminController::class,"subadminRoles"])->middleware("loggedAdmin");
     Route::post("/updatesubadminroles",[SubadminController::class,"updateSubadminRoles"])->middleware("loggedAdmin");






     //Transactions
      //deposits
  Route::get("/deposits",[AdminTransactionsController::class,"deposits"])->middleware("loggedAdmin");
  Route::get("/searchdeposit",[AdminTransactionsController::class,"depositSearch"])->middleware("loggedAdmin");
  Route::post("/deletedeposit",[AdminTransactionsController::class,"deleteDeposit"])->middleware("loggedAdmin");
  Route::get("/withdrawals",[AdminTransactionsController::class,"withdrawals"])->middleware("loggedAdmin");
  Route::post("/deletewithdrawal",[AdminTransactionsController::class,"deleteWithdrawal"])->middleware("loggedAdmin");
  //deposits
  Route::get("/transfers",[AdminTransactionsController::class,"transfers"])->middleware("loggedAdmin");
  Route::get("/searchtransfer",[AdminTransactionsController::class,"transferSearch"])->middleware("loggedAdmin");
  Route::post("/deletetransfer",[AdminTransactionsController::class,"deleteTransfer"])->middleware("loggedAdmin");
   /*
  Route::get("/exchange",[AdminTransactionsController::class,'exchange']);
  Route::get("/foreign",[AdminTransactionsController::class,"foreign"]);
  Route::post("/updateexchangestatus",[AdminTransactionsController::class,"updateExchangeStatus"])->middleware("loggedAdmin");
  Route::post("/updateforeignstatus",[AdminTransactionsController::class,"updateForeignStatus"])->middleware("loggedAdmin");
 */
  //commisions
  Route::get("/activities",[DashboardController::class,"activities"])->middleware("loggedAdmin");
  Route::get("/activity/{id}",[DashboardController::class,"activity"])->middleware("loggedAdmin");
  Route::get("/today",[DashboardController::class,"dayActivities"])->middleware("loggedAdmin");
  Route::get("/week",[DashboardController::class,"weekActivities"])->middleware("loggedAdmin");
  Route::get("/month",[DashboardController::class,"monthActivities"])->middleware("loggedAdmin");

 //analytics
 Route::get("dayanalytics",[DashboardController::class,"dayAnalytics"])->middleware("loggedAdmin");
 Route::get("weekanalytics",[DashboardController::class,"weekAnalytics"])->middleware("loggedAdmin");
 Route::get("monthanalytics",[DashboardController::class,"monthAnalytics"])->middleware("loggedAdmin");
Route::get("/redirect",function(){
    return redirect()->back();
})->middleware("loggedAdmin");


  Route::get("/commissions",[SettingsController::class,"transactionCharges"])->middleware("loggedAdmin");
  Route::get("/commission/{id}",[SettingsController::class,"charge"])->middleware("loggedAdmin");
  Route::post("/updatecommission",[SettingsController::class,"updateCharge"])->middleware("loggedAdmin");
  Route::post("/deletecommission",[SettingsController::class,"deleteCharge"])->middleware("loggedAdmin");
  Route::get("/newcommission",[SettingsController::class,"newCharge"])->middleware("loggedAdmin");
  Route::post("/savecommission",[SettingsController::class,"saveCharge"])->middleware("loggedAdmin");
  Route::get("/minimumbalance",[SettingsController::class,"minimumWalletBalance"])->middleware("loggedAdmin");
  Route::post("/updateminimumbalance",[SettingsController::class,"updateMinimumBalance"])->middleware("loggedAdmin");
  Route::get("/vtpassbalance",[AdminVtpassController::class,"vtpassBalance"]);
  Route::get("/educationcharges",[SettingsController::class,"educationCharges"]);
  Route::post("/updateeducationcharges",[SettingsController::class,"updateEducationCharges"]);
  
  //advert
  Route::get("/adverts",[SettingsController::class,'adverts']);
  Route::get("/newadvert",[SettingsController::class,"newAdvert"]);
  Route::post("/saveadvert",[SettingsController::class,'saveAdvert']);
  Route::post("/deleteadvert",[SettingsController::class,"deleteAdvert"]);

  Route::get("/logout",[AuthController::class,"logout"])->middleware("loggedAdmin");
  Route::get("/updatesettings",[AuthController::class,"account"])->middleware('loggedAdmin');
  Route::post("resetaccount",[AuthController::class,"resetAccount"])->middleware("loggedAdmin");
  Route::get("/packages",[SettingsController::class,"packages"])->middleware("loggedAdmin");
  Route::get("/package/{id}",[SettingsController::class,"package"])->middleware("loggedAdmin");
  Route::get("/newpackage",[SettingsController::class,"newPackage"])->middleware("loggedAdmin");
  Route::post("/savepackage",[SettingsController::class,"savePackage"])->middleware("loggedAdmin");
  Route::post("/updatepackage",[SettingsController::class,"updatePackage"])->middleware("loggedAdmin");
  Route::post("/deletepackage",[SettingsController::class,"deletePackage"])->middleware("loggedAdmin");

  //smart recharge
  Route::get("/smartcharges",[SettingsController::class,"smartRechargeCharges"])->middleware("loggedAdmin");
  Route::get("/newsmartcharge",[SettingsController::class,"newSmartCharge"])->middleware("loggedAdmin");
  Route::post("/savesmartcharge",[SettingsController::class,"saveSmartCharge"])->middleware("loggedAdmin");
  Route::get("/smartcharge/{id}",[SettingsController::class,"smartCharge"])->middleware("loggedAdmin");
  Route::post("/updatesmartcharge",[SettingsController::class,"updateSmartCharge"])->middleware("loggedAdmin");
  Route::post("/deletesmartcharge",[SettingsController::class,"deleteSmartCharge"])->middleware("loggedAdmin");
  Route::get("/smartdata",[AdminSmartController::class,"smartData"])->middleware("loggedAdmin");
  Route::get("/smartbalance",[AdminSmartController::class,"getBalance"])->middleware("loggedAdmin");
  Route::get("/verifysmartdata/{id}",[AdminSmartController::class,"verifySmartData"])->middleware("loggedAdmin");
    
  //vtpass
  Route::get("/vtpassairtime",[AdminVtpassController::class,"vtpassAirtime"])->middleware("loggedAdmin");
  Route::get("/vtpassdata",[AdminVtpassController::class,"vtpassData"])->middleware("loggedAdmin");
  Route::get("/vtpasscable",[AdminVtpassController::class,"vtpassCable"])->middleware("loggedAdmin");
  Route::get("/vtpasselectricity",[AdminVtpassController::class,"vtpassElectricity"])->middleware("loggedAdmin");
  Route::get("/vtpasseducation",[AdminVtpassController::class,"vtpassEducation"])->middleware("loggedAdmin");
  Route::get("/getvtpassbalance",[VTpassController::class,"getBalance"]);
  Route::get("/updatevtpassservices",[VTpassController::class,"getServices"]);

  Route::get("/airtimetocash",[AdminVtpassController::class,"airtimeToCash"]);
  Route::get("/confirmairtimetocash/{id}",[AdminVtpassController::class,"confirmAirtimeTocash"]);
  Route::get("/deleteairtimetocash/{id}",[AdminVtpassController::class,"deleteAirtimeTocash"]);

  Route::get("/bulksms",[AdminVtpassController::class,"bulksms"]);
  Route::get("/card",[AdminVtpassController::class,"card"]);

   //opendata
   /*
   Route::get("/opendatapackages",[AdminOpenDataController::class,"openDataPackages"]);
   Route::get("/newopendatapackage",[AdminOpenDataController::class,"newOpenDataPackage"]);
   Route::post("/saveopendatapackage",[AdminOpenDataController::class,"saveOpenDataPackage"]);
   Route::get("/opendatapackage/{id}",[AdminOpenDataController::class,"openDataPackage"]);
   Route::post("/updateopendatapackage",[AdminOpenDataController::class,"updateOpenDataPackage"]);
   Route::get("/deleteopendatapackage/{id}",[AdminOpenDataController::class,"deleteOpenDataPackage"]);
 */
     
});

