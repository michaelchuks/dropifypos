@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")
<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Dropifypay Subadmins
    </span> <a href="{{route('admin.subadmin.create')}}" class="btn btn-sm btn-success">Create Subadmin</a> </h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($subadmins) == 0)
               <strong class="text-danger">No Subadmin added yet</strong>
           
               @else

           <div class="table-responsive" id="deposits-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Fullname</th><th>Email</th><th>Image</th><th></th><th></th></tr>
           </thead>
           <tbody>
               @foreach($subadmins as $deposit)
               <tr><td>{{ucwords($deposit->name)}}</td>
               <td>{{$deposit->email}}</td>
               <td><img src="{{asset("storage/subadmin/$deposit->image")}}" style="width:200px;height:180px;" /></td>
               <td>{{$deposit->created_at}}</td>
    
               <td>
               
            <a href="{{url("/deletesubadmin/$deposit->id")}}" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span> Delete</a>
                   
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