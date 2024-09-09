@extends('layouts.adminheader')
@section('content')
@include('layouts.adminavigation')


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>OpenData Data Packages</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($packages) == 0)
               <strong class="text-danger">No OpenData Package set</strong>
           
               @else

           
           <div class="table-responsive" id="users-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>data ID</th><th>Network</th><th>Duration</th><th>Size</th><th>Cost Price</th><th>Selling Price</th><th></th><th></th></tr>
           </thead>
           <tbody>
               @foreach($packages as $charge)
               <td>{{$charge->data_id}}</td>
               <td>{{$charge->network}}</td>
               <td>{{$charge->duration}}</td>
               <td>{{$charge->size}}</td>
               <td>{{$charge->cost_price}}</td>
               <td>{{$charge->selling_price}}</td>
               <td><a href="{{url("/admin/opendatapackage/$charge->id")}}" class="btn btn-sm btn-success"><span class="fa fa-compass"></span> Edit</a></td>
               <td>
                <a href="{{url("/admin/deleteopendatapackage/$charge->id")}}" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span>Delete</a></td>
               </td>

               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
          
           </div>
           @endif
   
       </div>
      </div>
   




@include("layouts.adminfooter")
@endsection