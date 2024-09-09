@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>update Minimum Wallet Balance</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
            @if(Session::get("success"))
            <div class="alert alert-success">
           <strong class="text-success">{{Session::get("success")}}</strong>
            </div>
              @endif
 

    <form method="post" action="{{url("/updateminimumbalance")}}">
   @csrf
   <label><strong>Minimum Wallet Balance</strong></label>
   <input type="number" name="balance" placeholder="N{{$minimum_balance->minimum_wallet_balance}}" class="form-control" required />

   <br />
   <input type="hidden" name="balance_id" value="{{$minimum_balance->id}}" />
   

   <input type="submit" name="update_balance_btn" value="Update" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection