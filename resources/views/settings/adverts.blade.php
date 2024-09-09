@extends('layouts.adminheader')
@section('content')
@include('layouts.adminavigation')


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Packages</span> <a href="{{url("/admin/newadvert")}}" class="btn btn-sm btn-success"><span class="fa fa-plus"></span>Add Advert</a></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($adverts) == 0)
               <strong class="text-danger">No Adverts set</strong>
           
               @else

           
           <div class="table-responsive" id="users-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th></th><th></th></tr>
           </thead>
           <tbody>
               @foreach($adverts as $package)
               <td><img src="{{asset("storage/adverts/$package->advert")}}" style="width:200px;height:100px; border-radius:6px;"/> </td>
             
              
             
               <td>
                   <form method="post" action="{{url("/admin/deleteadvert")}}">
                       @csrf
                       <input type="hidden" name="advert_id" value="{{$package->id}}" />
                       <button method="submit" class="btn btn-sm btn-danger" name="delete_advert_btn"><span class="fa fa-trash"></span> Delete</button>
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