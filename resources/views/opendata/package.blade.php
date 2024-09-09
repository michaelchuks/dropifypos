@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>OpenData Package</span>
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
  

    <form method="post" action="{{url("/admin/updateopendatapackage")}}">
   @csrf
   <label><strong>Data ID </strong></label>
   <input type="tel" readonly name="data_id" placeholder="{{$package->data_id}}"  class="form-control"  />
   <br />

   <label><strong>Network </strong></label>
   <select name="network"  class="form-control">
    <option value="{{$package->network}}">{{$package->network}}</option>
  
   </select>
   <br />

   <label>Plan type</label>
   <select name="plan_type" class="form-control">
    <option value="{{$package->plan_type}}">{{$package->plan_type}}</option>
   </select>

   <br />
   <label><strong>Cost price</strong></label>
   <input type="tel" name="cost_price" placeholder="{{$package->cost_price}}"  class="form-control"  />
   <br />


   <label><strong>Selling price</strong></label>
   <input type="tel" name="selling_price" placeholder="{{$package->selling_price}}" class="form-control"  />
   <br />


   <label><strong>Size</strong></label>
   <input readonly type="text" name="size" placeholder="{{$package->size}}" class="form-control"  />
   <br />



   <label><strong>Duration</strong></label>
   <input type="text" readonly class="form-control" placeholder="{{$package->duration}}" name="duration">
     <br />


    <input type="hidden" name="package_id" value="{{$package->id}}" />

   <input type="submit" name="update_package_btn" value="Update" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection