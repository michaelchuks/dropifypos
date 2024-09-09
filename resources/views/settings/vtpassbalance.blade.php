@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Admin vtpass Wallet Balance</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
         
 
<center>

<h4><strong>Your vtpass wallet balance</strong></h4>
<h2><strong><del>N</del>{{$wallet_balance}}</strong></h2>
</center>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection