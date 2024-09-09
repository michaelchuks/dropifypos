@extends('layouts.adminheader')
@section('content')
@include('layouts.adminavigation')


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span> Airtime To Cash Records</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($data) == 0)
               <strong class="text-danger">No Airtime To Cash transaction yet</strong>
           
               @else

           
           <div class="table-responsive" id="users-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Username</th><th>Network</th><th>Amount(N)</th><th>Card Digits</th><th></th><th></th></tr>
           </thead>
           <tbody>
               @foreach($data as $charge)
               <td>{{$charge->user->username}}</td>
               <td>{{$charge->network}}</td>
               <td>{{$charge->amount}}</td>
               <td>{{$charge->card_digits}}</td>

               <td>
                @if($charge->status == "pending")
                <a href="{{url("admin/confirmairtimetocash/$charge->id")}}" class="btn btn-sm btn-success">Confirm</a>
                @endif
            </td>
               <td>
                @if($charge->status == "pending")
                <a href="{{url("admin/deleteairtimetocash/$charge->id")}}" class="btn btn-sm btn-danger">Delete</a>
                @endif
            </td>
             
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
           {{$data->links()}}
           </div>
           @endif
   
       </div>
      </div>
   




@include("layouts.adminfooter")
@endsection