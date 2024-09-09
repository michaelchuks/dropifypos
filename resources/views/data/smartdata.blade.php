@extends('layouts.adminheader')
@section('content')
@include('layouts.adminavigation')


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>SmartRecharge Data</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif

               @if(Session::get("error"))
               <div class="alert alert-danger">
                <strong class="text-danger">{{Session::get("error")}}</strong>
               </div>
              @endif
               @if(count($smart_data) == 0)
               <strong class="text-danger">No Data transaction yet</strong>
           
               @else

           
           <div class="table-responsive" id="users-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Username</th><th>Product</th><th>Performed On</th><th>Amount(N)</th><th>Amount charged(N)</th><th>User Charge(N)</th><th>Admin Share(N)</th><th></th></tr>
           </thead>
           <tbody>
               @foreach($smart_data as $charge)
               <td>{{$charge->user->username}}</td>
               <td>{{$charge->product_name}}</td>
               <td>{{$charge->unique_equivalent}}</td>
               <td>{{$charge->amount}}</td>
               <td>{{$charge->amount_charged}}</td>
               <td>{{$charge->user_charge}}</td>
               <td>{{$charge->admin_share}}</td>
               <td><a href="{{url("admin/verifysmartdata/$charge->id")}}" class="btn btn-sm btn-success"><span class="fa fa-compass"></span> Verify Status</a></td>
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
           {{$smart_data->links()}}
           </div>
           @endif
   
       </div>
      </div>
   




@include("layouts.adminfooter")
@endsection