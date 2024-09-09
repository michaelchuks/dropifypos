<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VtpassTransactions;
use App\Models\User;


class AdminVtpassController extends Controller
{
    public $sandbox_url = "https://vtpass.com/api/";
    //public $sandbox_url = "https://sandbox.vtpass.com/api/";
    public $username = "dropify2018@gmail.com";
    public $password = "Prinbhobhoangel24#";

    public function vtpassBalance(){

        
            $username = $this->username;
            $password = $this->password;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://vtpass.com/api/balance");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            $result = curl_exec($ch);

           
            curl_close($ch);  
            $balance_details = json_decode($result,true);
          

            $wallet_balance = $balance_details["contents"]["balance"];
              return view("settings.vtpassbalance")->with("wallet_balance",$wallet_balance);
      
          
    }


    public function vtpassAirtime(){
        $vtpass_airtime = VtpassTransactions::where("transaction_type","=","airtime")->orderBy("id","desc")->paginate(30);
        return view("airtime.vtpassairtime")->with("vtpass_airtime",$vtpass_airtime);
    }

    public function vtpassData(){
        $vtpass_data = VtpassTransactions::where("transaction_type","=","data")->orderBy("id","desc")->paginate(30);
        return view("data.vtpassdata")->with("vtpass_data",$vtpass_data);
    }


    public function vtpassCable(){
        $vtpass_cable = VtpassTransactions::where("transaction_type","=","cable")->orderBy("id","desc")->paginate(30);
        return view("cable.vtpasscable")->with("vtpass_cable",$vtpass_cable);
    }


    public function vtpassElectricity(){
        $vtpass_electricity = VtpassTransactions::where("transaction_type","=","electricity")->orderBy("id","desc")->paginate(30);
        return view("electricity.vtpasselectricity")->with("vtpass_electricity",$vtpass_electricity);
    }


    public function vtpassEducation(){
        $vtpass_education = VtpassTransactions::where("transaction_type","=","eductaion")->orderBy("id","desc")->paginate(30);
        return view("education.vtpasseducation")->with("vtpass_education",$vtpass_education);
    }


   







}
