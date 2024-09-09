@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Add OpenData Package</span>
    <a href="{{url("/admin/opendatapackages")}}" class="btn btn-sm btn-primary"> Packages</a>
  </h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">

            @if(Session::get("success"))
          <div class="alert alert-success">
         <strong class="text-success">{{Session::get("success")}}</strong>
          </div>
            @endif
  

    <form method="post" action="{{url("/admin/saveopendatapackage")}}">
   @csrf
   <label><strong>Data ID </strong></label>
   <input type="tel" name="data_id"  class="form-control" required />
   <br />

   <label><strong>Network </strong></label>
   <select name="network"  class="form-control">
    <option value="MTN">MTN</option>
    <option value="AIRTEL">AIRTEL</option>
    <option value="9MOBILE">9MOBILE</option>
    <option value="GLO">GLO</option>
   </select>
   <br />

   <label>Plan type</label>
   <select name="plan_type" class="form-control">
    <option value="SME">SME</option>
    <option value="GIFTING">GIFTING</option>
    <option value="CORPORATE GIFTING">CORPORATE GIFTING</option>
    <option value="DATA COUPON">DATA COUPON</option>
   </select>

   <br />
   <label><strong>Cost price</strong></label>
   <input type="tel" name="cost_price"  class="form-control" required />
   <br />


   <label><strong>Selling price</strong></label>
   <input type="tel" name="selling_price"  class="form-control" required />
   <br />


   <label><strong>Size</strong></label>
   <input type="text" name="size"  class="form-control" required />
   <br />



   <label><strong>Duration</strong></label>
   <input type="text" class="form-control" name="duration" required>
     <br />


   

   <input type="submit" name="save_package_btn" value="Save" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection