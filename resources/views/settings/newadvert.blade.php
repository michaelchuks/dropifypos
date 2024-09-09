@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Add new Advert</span></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
               <div class="alert alert-success">
                   <strong class="text-light">{{Session::get("success")}}</strong>
               </div>
               
               @endif
   

    <form method="post" action="{{url("/admin/saveadvert")}}" enctype="multipart/form-data">
   @csrf
   <label><strong class="text-success">Advert</strong></label>
   <input type="file" accept="image/*" name="image"  class="form-control"  />
  <br />
  
   

   <input type="submit" name="save_advert_btn" value="Save" class="btn btn-sm btn-success" />


            </form>
           </div>
        </div>
    </div>



@include("layouts.adminfooter")
@endsection