@extends('layouts.adminheader')
@section('content')
@include('layouts.adminavigation')


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Transaction Commisions</span> <a href="{{url("/newcommission")}}" class="btn btn-sm btn-success"><span class="fa fa-plus"></span>Add Commission</a></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($transaction_charges) == 0)
               <strong class="text-danger">No Commission set</strong>
           
               @else

           
           <div class="table-responsive" id="users-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Transaction</th><th>Api Platform</th><th>Agent Commission(%)</th><th></th></tr>
           </thead>
           <tbody>
               @foreach($transaction_charges as $charge)
               <td>{{$charge->transaction_type}}</td>
               <td>{{$charge->charge}}%</td>
               <td><a href="{{url("/commission/$charge->id")}}" class="btn btn-sm btn-success"><span class="fa fa-compass"></span> Edit</a></td>
               <td>
                   <form method="post" action="{{url("/deletecommission")}}">
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
   
           {{$transaction_charges->links()}}
           </div>
           @endif
   
       </div>
      </div>
   




@include("layouts.adminfooter")
@endsection