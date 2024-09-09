@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")
<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Dropifypay Subadmin Roles
    </span> <a href="{{route('admin.agreegator.create')}}" class="btn btn-sm btn-success">Update Subadmin Roles</a> </h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($roles) == 0)
               <strong class="text-danger">No Subadmin roles added yet</strong>
           
               @else
           <form method="post" action="{{url("/updatesubadminroles")}}">
            @csrf
           <div class="table-responsive" id="deposits-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Role</th><th>Status</th></tr>
           </thead>
           <tbody>
               @foreach($roles as $role)
               <tr>
                <td>{{ucwords($role->privilege)}}</td>
               <td>
                @if($role->is_active == 1)
                <input type="checkbox" name="roles[]" value="{{$role->id}}" checked />
                @else
                <input type="checkbox" name="roles[]" value="{{$role->id}}"/>
                @endif
               </td>
           
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
           </div>
           <input type="submit" class="btn btn-sm btn-primary" value="Update" />
        </form>
           @endif
   
       </div>
      </div>
   

   


@include("layouts.adminfooter")
@endsection