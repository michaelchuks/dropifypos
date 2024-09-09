@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Add Package</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">

            @if(Session::get("success"))
          <div class="alert alert-success">
         <strong class="text-success">{{Session::get("success")}}</strong>
          </div>
            @endif
  

    <form method="post" action="{{url("/admin/updatepackage")}}">
   @csrf
   <label><strong>Package Name </strong></label>
   <input type="text" name="package"  class="form-control" placeholder="{{$package->package}}"/>

   <br />
   <label><strong>Upgrade Amount</strong></label>
   <input type="number" name="upgrade_amount"  class="form-control" placeholder="{{$package->upgrade_amount}}" /><br />
   
   <label><strong>Description</strong></label>
   <textarea class="form-control" name="description">
       {{$package->description}}
       </textarea><br />

<input type="hidden" name="package_id" value="{{$package->id}}" />
   

   <input type="submit" name="update_package_btn" value="Update" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection