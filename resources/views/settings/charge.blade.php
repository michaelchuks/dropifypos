@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>update Commission</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
   <p>Api Platform : {{$charge->api_platform}}</p>
   <p>Transaction Type : {{$charge->transaction_type}}</p>

    <form method="post" action="{{url("/updatecommission")}}">
   @csrf
   <label><strong class="text-success">Commission(%)</strong></label>
   <input type="number" name="charge" placeholder="{{$charge->charge}}%" class="form-control"  />
  <br />
   <label><strong>Select Package Type</strong></label>
   <select name="package_type" class="form-control">
    <option value="{{$charge->package_type}}">{{ucwords($charge->package_type)}}</option>  
   </select>
   <br />

   <br />
   <input type="hidden" name="charge_id" value="{{$charge->id}}" />
   

   <input type="submit" name="update_charge_btn" value="Update" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection