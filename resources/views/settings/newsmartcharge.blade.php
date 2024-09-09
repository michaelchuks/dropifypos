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
  

    <form method="post" action="{{url("/savesmartcharge")}}">
   @csrf
  
   <label><strong>Product Name</strong></label>
   <select name="product_name"  class="form-control" required>
   @foreach($smart_services as $service)
    <option value="{{$service->product_name}}">{{$service->product_name}}</option>
   @endforeach
   </select>
    <br />


   <label><strong>Network</strong></label>
   <input type="text" name="network"  class="form-control" required /><br />

   <label><strong>Select Package Type</strong></label>
   <select name="package_type" class="form-control">
    @foreach($packages as $package)
    <option value="{{$package->package}}">{{ucwords($package->package)}}</option>
    @endforeach
   </select>
   <br />



   <label><strong>Original Charge(<del>N</del>)</strong></label>
   <input type="number" name="original_charge"  class="form-control" required />

   <br />

   <label><strong>User Charge(<del>N</del>)</strong></label>
   <input type="number" name="user_charge"  class="form-control" required />

   <br />

   <input type="submit" name="save_charge_btn" value="Save" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection