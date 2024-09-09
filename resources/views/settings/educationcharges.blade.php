@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>update Education Charges</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
            @if(Session::has("success"))
            <div class="alert alert-success">
                <strong class="text-success">{{Session::get("success")}}</strong>
            </div>

            @endif
  

    <form method="post" action="{{url("/updateeducationcharges")}}">
   @csrf
   <label><strong class="text-success">Waec Result Checker Pin(<del>N</del>)</strong></label>
   <input type="number" name="waec" placeholder="{{$charges->waec}}" class="form-control"  />
  <br />



 


 <label><strong class="text-success">Jamb Pin(<del>N</del>)</strong></label>
 <input type="number" name="jamb" placeholder="{{$charges->jamb}}" class="form-control"  />
<br />
  
  



   

   <input type="submit" name="update_charge_btn" value="Update" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection