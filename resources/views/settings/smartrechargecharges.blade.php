@extends('layouts.adminheader')
@section('content')
@include('layouts.adminavigation')


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>SmartRecharge Transaction Charges</span> <a href="{{url("/admin/newsmartcharge")}}" class="btn btn-sm btn-success"><span class="fa fa-plus"></span>Add Charge</a></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($charges) == 0)
               <strong class="text-danger">No Charges set</strong>
           
               @else

           
           <div class="table-responsive" id="users-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Transaction</th><th>Network</th><th>Package Type</th><th>Original Charge(<del>N</del>)</th><th>User Charge(<del>N</del>)</th><th></th><th></th></tr>
           </thead>
           <tbody>
               @foreach($charges as $charge)
               <td>{{$charge->product_name}}</td>
               <td>{{$charge->network}}</td>
               <td>{{$charge->package_type}}</td>
               <td>{{$charge->original_charge}}</td>
               <td>{{$charge->user_charge}}</td>
               <td><a href="{{url("/admin/smartcharge/$charge->id")}}" class="btn btn-sm btn-success"><span class="fa fa-compass"></span> Edit</a></td>
               <td>
                   <form method="post" action="{{url("/admin/deletesmartcharge")}}">
                       @csrf
                       <input type="hidden" name="charge_id" value="{{$charge->id}}" />
                       <button method="submit" class="btn btn-sm btn-danger" name="delete_charge_btn"><span class="fa fa-trash"></span> Delete</button>
                   </form>
               </td>

               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
           {{$charges->links()}}
           </div>
           @endif
   
       </div>
      </div>
   




@include("layouts.adminfooter")
@endsection