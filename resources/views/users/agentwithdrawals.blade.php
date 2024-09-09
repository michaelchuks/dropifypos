@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")
<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Withdrawals for {{$data}}</span>     
    <a href="{{url("user/$id")}}" class="btn btn-sm btn-danger">Back to Profile</a>
    <span class="text-success">Total: &#8358;{{$total}}</h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($withdrawals) == 0)
               <strong class="text-danger">No Withdrawals Yet</strong>
           
               @else

       
           <div class="table-responsive" id="deposits-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Card Holder</th><th>Card Type</th><th>Amount</th><th>Transaction Charge</th><th>Reference Id</th><th>Date</th><th></th></tr>
           </thead>
           <tbody>
               @foreach($withdrawals as $deposit)
               @php
               $timestamp = strtotime($deposit->created_at) ;
               $day = date("l",$timestamp);
               $month = date("F",$timestamp);
               $year = date("Y",$timestamp);
               $time = date("h:i:A",$timestamp);
               @endphp
               <tr>
                <td>{{$deposit->card_holder}}</td>
                <td>{{$deposit->card_scheme}}</td>
               <td>&#8358;{{$deposit->amount}}</td>
               <td>&#8358;{{$deposit->charge}}
               <td>{{$deposit->rrn}}</td>
               <td>{{$time}} {{$day}} {{$month}} {{date("d",$timestamp)}} {{$year}}</td>
    
               <td>
                   <form method="post" action="{{url("/deletewithdrawal")}}">
                       @csrf
                       <input type="hidden" name="withdrawal_id" value="{{$deposit->id}}" />
                       <button method="submit" class="btn btn-sm btn-danger" name="delete_withdrawal_btn"><span class="fa fa-trash"></span> Delete</button>
                   </form>
               </td>
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
           {{$withdrawals->links()}}
           </div>
           @endif
   
       </div>
      </div>
   

     


@include("layouts.adminfooter")
@endsection