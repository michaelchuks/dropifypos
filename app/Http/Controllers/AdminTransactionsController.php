<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposits;
use App\Models\Transfers;
use App\Models\Withdrawals;
use App\Models\User;

class AdminTransactionsController extends Controller
{
    

    public function deposits(){
        $total = Deposits::sum("amount");
        $deposits = Deposits::orderBy("id","desc")->paginate(30);
        return view("transactions.deposits")->with("deposits",$deposits)->with("total",$total);
    }


    public function depositSearch(Request $request){
        $username = $request->username;
       
        $deposits = Deposits::where("username","like","%{$username}%")->get();
        return view("transactions.depositsearch")->with("deposits",$deposits);
    
    }

    public function deleteDeposit(Request $request){
        if($request->has("delete_deposit_btn")){
             Deposits::find($request->deposit_id)->delete();
             return redirect()->back()->with("success","deposit deleted successfully");
        }else{
            return redirect()->to('/admin');
        }
    }



    public function transfers(){
        $total = Transfers::sum("amount");
        $transfers = Transfers::orderBy("id","desc")->paginate(30);
        return view("transfers.transfers")->with("transfers",$transfers)->with("total",$total);
    }


    public function transferSearch(Request $request){
        $username = $request->username;
        $transfers = Transfers::where("fullname","like","%{$username}%")->get();
        return view("transfers.transfersearch")->with("transfers",$transfers);
}


public function deleteTransfer(Request $request){
    if($request->has("delete_transfer_btn")){
         Transfers::find($request->transfer_id)->delete();
         return redirect()->back()->with("success","transfer deleted successfully");
    }else{
        return redirect()->to('/admin');
    }

}



public function withdrawals(){
    $withdrawals = Withdrawals::orderBy("id","desc")->paginate(30);
    $total = Withdrawals::sum("amount");
    return view('transactions.withdrawals')->with("withdrawals",$withdrawals)->with("total",$total);
}



public function deleteWithdrawal(Request $request){
    if($request->has("delete_withdrawal_btn")){
         Withdrawals::find($request->withdrawal_id)->delete();
         return redirect()->back()->with("success","withdrawal deleted successfully");
    }else{
        return redirect()->to('/admin');
    }

}



/*

 public function foreign(){
    $data = Foreign::orderBy("id","desc")->paginate(30);
    return view("transactions.foreign")->with("data",$data);
 }


 public function updateForeignStatus(Request $request){
    Foreign::find($request->id)->update([
        "status" => true
    ]);

    return redirect()->back()->with("success","foreign transfer status updated successfully");
 }



public function exchange(){
    $data = Exchange::orderBy("id","desc")->paginate(30);
    return view("transactions.exchange")->with("data",$data);
}


public function updateExchangeStatus(Request $request){
    Exchange::find($request->id)->update([
        "status" => true
    ]);

    return redirect()->back()->with("success","Exchange status updated successfully");
 }


*/

}
