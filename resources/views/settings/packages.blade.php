@extends('layouts.adminheader')
@section('content')
@include('layouts.adminavigation')


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Packages</span> <a href="{{url("/admin/newpackage")}}" class="btn btn-sm btn-success"><span class="fa fa-plus"></span>Add Package</a></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($packages) == 0)
               <strong class="text-danger">No Package set</strong>
           
               @else

           
           <div class="table-responsive" id="users-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Package Name</th><th>Upgrade Amount</th><th></th><th></th></tr>
           </thead>
           <tbody>
               @foreach($packages as $package)
               <td>{{$package->package}}</td>
               <td>{{$package->upgrade_amount}}</td>
              
               <td><a href="{{url("/admin/package/$package->id")}}" class="btn btn-sm btn-success"><span class="fa fa-compass"></span> Edit</a></td>
               <td>
                   <form method="post" action="{{url("/admin/deletepackage")}}">
                       @csrf
                       <input type="hidden" name="package_id" value="{{$package->id}}" />
                       <button method="submit" class="btn btn-sm btn-danger" name="delete_package_btn"><span class="fa fa-trash"></span> Delete</button>
                   </form>
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