@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Smart Recharge Verification</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
    <h5>
     @if($transaction_status == "COMPLETED")
    <strong class="text-success">Status : {{$transaction_status}}</strong>
    @else
    <strong class='text-danger'>Status : {{$transaction_status}}</strong>
     @endif
    </h5>
    <p>Product : {{$smart_data->product_name}}</p>
   <p>User : {{$smart_data->user->username}}</p>
   <p>Transaction Type : {{$smart_data->transaction_type}}</p>
   <p>Transaction Amount :  <del>N</del>{{$smart_data->amount_charged}}</p>
   <p>Amount Charged : <del>N</del>{{$smart_data->user_charge}}</p>

    @php
     $transaction_time = strtotime($smart_data->created_at);
     $current_time = strtotime(date("H:i jS F Y"));
     $difference = $current_time - $transaction_time;
    @endphp

     @if($transaction_status != "COMPLETED" && $difference > 21600)
     <a href="{{url("admin/fundwallet/$smart_data->user_id")}}" class="btn btn-sm btn-success">Refund User</a>
     @endif

  
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection