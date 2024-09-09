@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Add Commission</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">

            @if(Session::get("success"))
          <div class="alert alert-success">
         <strong class="text-success">{{Session::get("success")}}</strong>
          </div>
            @endif
  

    <form method="post" action="{{url("/savecommission")}}">
   @csrf
   <label><strong>Commission(%)</strong></label>
   <input type="number" name="charge"  class="form-control" required />

   <br />
   <label><strong>Api Platform</strong></label>
   <input type="text" name="api_platform"  class="form-control" required /><br />


   <label><strong>Transaction Type</strong></label>
   <input type="text" name="transaction_type"  class="form-control" required /><br />

     <input type="hidden" name="package_type" value="end user" />

   <input type="submit" name="save_charge_btn" value="Save" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection