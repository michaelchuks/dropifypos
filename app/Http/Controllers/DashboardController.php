<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\Admin;


class DashboardController extends Controller
{
    
    public function activities(){
        $activities = Activities::orderBy("id","desc")->paginate(30);
        $total = Activities::sum("amount");
        return view("activities")->with("activities",$activities)->with("data","all")->with("total",$total);
    }


    public function activity($id){
        $activity = Activities::find($id);
        return view("activity")->with("activity",$activity);
    }


    public function searchActivity(Request $request){

    }

    public function dayActivities(){
        $data = strtotime(date("Y-m-d"));
        $year = date("Y",$data);
        $month = date("F",$data);
        $day = date("d",$data);
     
        $activities = Activities::where("year","=",$year)->where("month","=",$month)->where("day","=",$day)->orderBy("id","desc")->paginate(30);
        $total = Activities::where("year","=",$year)->where("month","=",$month)->where("day","=",$day)->sum("amount");
        return view("activities")->with("activities",$activities)->with("total",$total)->with("data",$day . "/" . $month . "/" . $year)->with("type","day");

    }


    public function weekActivities(){
        $data = strtotime(date("Y-m-d"));
        $week = date("W", $data);
        $year = date("Y",$data);
        $activities = Activities::where("year","=",$year)->where("week","=",$week)->orderBy("id","desc")->paginate(30);
        $total = Activities::where("year","=",$year)->where("week","=",$week)->sum("amount");
        return view("activities")->with("activities",$activities)->with("total",$total)->with("data","week " . $week . "/" . $year)->with("type","week");
    }


    public function monthActivities(){
        $data = strtotime(date("Y-m-d"));
        $year = date("Y",$data);
        $month = date("F",$data);
        $activities = Activities::where("year","=",$year)->where("month","=",$month)->orderBy("id","desc")->paginate(30);
        $total = Activities::where("year","=",$year)->where("month","=",$month)->sum("amount");
        return view("activities")->with("activities",$activities)->with("total",$total)->with("data", $month . "/" . $year)->with("type","month");
    }






    public function dayAnalytics(){
        $data = strtotime(date("Y-m-d"));
        $year = date("Y",$data);
        $month = date("F",$data);
        $day = date("d",$data);
     
        $vtu_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("day","=",$day)->where("api_platform","=","vtpass")->count();
        $deposit_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("day","=",$day)->where("api_platform","=","deposit")->count();
        $transfer_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("day","=",$day)->where("api_platform","=","transfer")->count();
        $withdrawal_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("day","=",$day)->where("api_platform","=","withdrawal")->count();
        $total = Activities::where("year","=",$year)->where("month","=",$month)->where("day","=",$day)->count();
        $vtu_percent = ($vtu_activities/$total) * 100;
        $deposit_percent = ($deposit_activities/$total) * 100;
        $transfer_percent = ($transfer_activities/$total) * 100;
        $withdrawal_percent = ($withdrawal_activities/$total) * 100;
        return view("analytics")->with("activities",$activities)->with("total",$total)->with("data",$day . "/" . $month . "/" . $year)
        ->with("vtu",$vtu_percent)
        ->with("deposit",$deposit_percent)
        ->with("transfer",$transfer_percent)
        ->with("withdrawal",$withdrawal_percent);

    }


    public function weekAnalytics(){
        $data = strtotime(date("Y-m-d"));
        $week = date("W", $data);
        $year = date("Y",$data);
         
        $vtu_activities = Activities::where("year","=",$year)->where("week","=",$week)->where("api_platform","=","vtpass")->count();
        $deposit_activities = Activities::where("year","=",$year)->where("week","=",$week)->where("api_platform","=","deposit")->count();
        $transfer_activities = Activities::where("year","=",$year)->where("week","=",$week)->where("api_platform","=","transfer")->count();
        $withdrawal_activities = Activities::where("year","=",$year)->where("week","=",$week)->where("api_platform","=","withdrawal")->count();
        $total = Activities::where("year","=",$year)->where("week","=",$week)->count();
        $vtu_percent = ($vtu_activities/$total) * 100;
        $deposit_percent = ($deposit_activities/$total) * 100;
        $transfer_percent = ($transfer_activities/$total) * 100;
        $withdrawal_percent = ($withdrawal_activities/$total) * 100;
        return view("analytics")->with("total",$total)->with("data",$week .  "/" . $year)
        ->with("vtu",$vtu_percent)
        ->with("deposit",$deposit_percent)
        ->with("transfer",$transfer_percent)
        ->with("withdrawal",$withdrawal_percent);
    }


    public function monthAnalytics(){
        $data = strtotime(date("Y-m-d"));
        $year = date("Y",$data);
        $month = date("F",$data);
        
        $vtu_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("api_platform","=","vtpass")->count();
        $deposit_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("api_platform","=","deposit")->count();
        $transfer_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("api_platform","=","transfer")->count();
        $withdrawal_activities = Activities::where("year","=",$year)->where("month","=",$month)->where("api_platform","=","withdrawal")->count();
        $total = Activities::where("year","=",$year)->where("month","=",$month)->count();
        $vtu_percent = ($vtu_activities/$total) * 100;
        $deposit_percent = ($deposit_activities/$total) * 100;
        $transfer_percent = ($transfer_activities/$total) * 100;
        $withdrawal_percent = ($withdrawal_activities/$total) * 100;
        return view("analytics")->with("total",$total)->with("data", $month . " " . $year)
        ->with("vtu",$vtu_percent)
        ->with("deposit",$deposit_percent)
        ->with("transfer",$transfer_percent)
        ->with("withdrawal",$withdrawal_percent);



}





}
