@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>{{$activity->activity_type}} Deta</span>
  <button type="button" onclick="return window.history.back()" class="btn btn-sm btn-danger">Return</button>
</h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">

            @if(Session::get("success"))
          <div class="alert alert-success">
         <strong class="text-success">{{Session::get("success")}}</strong>
          </div>
            @endif
            @php
            if($activity->api_platform == "vtpass"){
                $details = \App\Models\VtpassTransactions::find($activity->platform_table_id);
            }else if($activity->api_platform == "transfer"){
                $details = \App\Models\Transfers::find($activity->platform_table_id);
            }else if($activity->api_platform == "withdrawal"){
                $details = \App\Models\Withdrawals::find($activity->platform_table_id);
            }
            @endphp
             <div class="row">
                <div class="col-md-6">
             <h6>Transaction Details</h6>
             <p><strong>Transaction : {{$activity->activity_type}}</strong></p>
             <p><strong>Amount : &#8358;{{$activity->amount}}</strong></p>
             <p><strong>Status :  Successful</strong></p>
                </div>

                <div class="col-md-6">
                    <h6>Transaction Data</h6>
                    @if($activity->api_platform == "transfer")
                    <p><strong>Account Name : {{$details->account_name}}</strong></p>
                    <p><strong>Account Number : {{$details->account_number}}</strong></p>
                    <p><strong>Bank Name : {{$details->bank}}</strong></p>
                    <p><strong>Transaction Charge : &#8358;{{$details->transaction_charge}}</strong></p>
                    <p><strong>Reference : {{$details->reference}}</strong></p>
                    @endif

                    @if($activity->api_platform == "withdrawal")
                    <p><strong>Card Holder : {{$details->card_holder}}</strong></p>
                    <p><strong>Card Type : {{$details->card_scheme}}</strong></p>
                    <p><strong>Terminal Id : {{$details->terminal_id}}</strong></p>
                    <p><strong>Serial No : {{$details->serial_no}}</strong></p>
                    <p><strong>Transaction Charge : &#8358;{{$details->charge}}</strong></p>
                    <p><strong>Reference : {{$details->rrn}}</strong></p>
                    @endif


                    @if($activity->api_platform == "vtpass")
                    <p><strong>Reciever : {{$details->unique_equivalent}}</strong></p>
                    <p><strong>vtpass Charge : &#8358;{{$details->amount_charged}}</strong></p>
                    <p><strong>User Charged : &#8358;{{$details->user_charge}}</strong></p>
                    <p><strong>Reference : {{$details->transaction_id}}</strong></p>
                    @endif
                    </div>
             </div>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection