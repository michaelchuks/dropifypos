<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VtpassController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Middleware\OnlyAcceptJsonMiddleware;


Route::post("/register",[AuthController::class,"register"]);
Route::post("/registerbusiness",[AuthController::class,"registerBusiness"]);
Route::post("/login",[AuthController::class,"login"]);
Route::post("/resendotp",[AuthController::class,"resendOtp"]);
Route::post("/checkotp",[AuthController::class,"checkotp"]);
Route::post("/forgotpassword",[AuthController::class,"forgotPassword"]);
Route::post("/resendpasswordcode",[AuthController::class,"resendPasswordCode"]);
Route::post("/verifycode",[AuthController::class,"VerifyCode"]);
Route::post("/savepassword",[AuthController::class,"savePassword"]);
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

  //flutterwave notification
  Route::post("/flutterwavenotification",[DashboardController::class,"flutterwaveNotification"])->middleware([OnlyAcceptJsonMiddleware::class,'auth:sanctum']);


Route::middleware('auth:sanctum')->group(function(){
    //transaction
    Route::get("/account",[AuthController::class,"accountDetails"]);
    Route::get("/transactions",[DashboardController::class,'activities']);
    Route::get("/transaction/{transaction_id}",[DashboardController::class,"activity"]);
    Route::get("/transfers",[DashboardController::class,"transfers"]);
     Route::get("/deposits",[DashboardController::class,"deposits"]);
   
    Route::get("/airtime",[VtpassController::class,"vtpassAirtime"]);
    Route::post("/confirmairtime",[VtpassController::class,"confirmVtpassAirtime"]);
    Route::post("/airtimerecharge",[VtpassController::class,"vtpassAirtimeRecharge"]);
    Route::post("/airtimesuccess",[VtpassController::class,"vtpassAirtimeSuccess"]);
    
    //data
    Route::get("/data",[VtpassController::class,"vtpassData"]);
    Route::post("/datavariations",[VtpassController::class,"vtpassDataVariations"]);
    Route::post("/confirmdata",[VtpassController::class,"confirmVtpassData"]);
    Route::post("/datatopup",[VtpassController::class,"vtpassDataTopup"]);
    Route::get("/datatopupsuccess",[VtpassController::class,"vtpassDataSuccess"]);
    
    
    //cable
    Route::get("/cable",[VtpassController::class,"vtpassCableSubscription"]);
    Route::post("/cablevariations",[VtpassController::class,"cableVariations"]);
    Route::post("/confirmcable",[VtpassController::class,"confirmVtpassCableSub"]);
    Route::post("/cablesubscription",[VtpassController::class,"vtpassCableSub"]);
    Route::post("/cablesubscriptionsuccess",[VtpassController::class,"vtpassCableSuccess"]);
    
    
    //electricity
    Route::get("/electricity",[VtpassController::class,"vtpassElectricity"]);
    Route::post("/confirmelectricbill",[VtpassController::class,"confirmElectrilBill"]);
    Route::post("/electricbillrecharge",[VtpassController::class,"electricityRecharge"]);
    Route::post("/electricbillsuccess",[VtpassController::class,"electricityBillSuccess"]);
    
    
    //transfer
Route::get("/initiate-transfer",[TransferController::class,"ercasLogin"]);
Route::get("/banks/{token}",[TransferController::class,"getBanks"]);
Route::post("/verifyaccount",[TransferController::class,"verifyAccount"]);
Route::post("/processtransfer",[TransferController::class,"processTransfer"]);
    
    
    
    //profile
     Route::get("/user",[AuthController::class,"user"]);
     Route::post("/updateprofile",[AuthController::class,"updateProfile"]);
     Route::post("/updatepassport",[AuthController::class,"updatePassport"]);
     
     //pin
     Route::post("/createpin",[AuthController::class,"createPin"]);
     Route::post("/verifypin",[AuthController::class,"verifyPin"]);
     Route::post("/changepin",[AuthController::class,'changePin']);
     
    
    
    
   
    
    
    
    
});