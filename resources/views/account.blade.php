@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Update Admin</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">

            @if(Session::get("success"))
          <div class="alert alert-success">
         <strong class="text-success">{{Session::get("success")}}</strong>
          </div>
            @endif
  

    <form method="post" action="{{url("/resetaccount")}}">
   @csrf
  

   <br />
   <label><strong>Email</strong></label>
   <input type="text" name="email"  placeholder="{{$admin->email}}" class="form-control" required /><br />


   <label><strong>Password</strong></label>
   <input type="password" name="password"  class="form-control" required /><br />

   <input type="hidden" value="{{$admin->id}}" name="admin_id" />

   <input type="submit" name="reset_account_btn" value="Save" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection