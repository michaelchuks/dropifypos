@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Add Charge</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">

            @if(Session::get("success"))
          <div class="alert alert-success">
         <strong class="text-success">{{Session::get("success")}}</strong>
          </div>
            @endif
  

    <form method="post" action="{{url("/admin/updatesmartcharge")}}">
   @csrf
  
   <label><strong>Product Name</strong></label>
   <select name="product_name"  class="form-control" required>
  
    <option value="{{$charge->product_name}}">{{$charge->product_name}}</option>
  
   </select>
    <br />


 

   <label><strong>Select Package Type</strong></label>
   <select name="package_type" class="form-control">
   
    <option value="{{$charge->package_type}}">{{ucwords($charge->package_type)}}</option>
   
   </select>
   <br />



   <label><strong>Original Charge(<del>N</del>)</strong></label>
   <input type="number" name="original_charge"  class="form-control" placeholder="{{$charge->original_charge}}"/>

   <br />

   <label><strong>User Charge(<del>N</del>)</strong></label>
   <input type="number" name="user_charge"  class="form-control" placeholder="{{$charge->user_charge}}"/>

   <br />

   <input type="hidden" name="charge_id" value="{{$charge->id}}" />

   <input type="submit" name="update_charge_btn" value="Update" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection