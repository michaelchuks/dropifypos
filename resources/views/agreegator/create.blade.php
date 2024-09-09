@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Create Agreegator</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">

            @if(Session::get("success"))
          <div class="alert alert-success">
         <strong class="text-success">{{Session::get("success")}}</strong>
          </div>
            @endif
  

    <form method="post" action="{{route("admin.agreegator.store")}}" enctype="multipart/form-data">
   @csrf
  

   <br />
   <label><strong>Name</strong></label>
   <input type="text" name="name"  placeholder="Agreegator Name" class="form-control" required /><br />




   <label><strong>Email</strong></label>
   @error('email')<br /><small class="text-danger"><strong>{{$message}}</strong></small><br />@enderror
   <input type="text" name="email"  placeholder="agreegatoremail" class="form-control" required /><br />


   <label><strong>Image</strong></label>
   @error('image')<br /><small class="text-danger"><strong>{{$message}}</strong></small><br />@enderror
   <input type="file" name="image"  placeholder="image" class="form-control" required /><br />


   <label><strong>Password</strong></label>
   @error('password')<br /><small class="text-danger"><strong>{{$message}}</strong></small><br />@enderror
   <input type="password" name="password"  class="form-control" required /><br />



   <input type="submit" name="reset_account_btn" value="Save" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection