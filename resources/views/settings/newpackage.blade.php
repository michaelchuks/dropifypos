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
  

    <form method="post" action="{{url("/admin/savepackage")}}">
   @csrf
   <label><strong>Package Name </strong></label>
   <input type="text" name="package"  class="form-control" required />

   <br />
   <label><strong>Upgrade Amount</strong></label>
   <input type="numbers" name="upgrade_amount"  class="form-control" required /><br />


   <label><strong>Description</strong></label>
   <textarea class="form-control" name="description" required>

       </textarea><br />


   

   <input type="submit" name="save_package_btn" value="Save" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection