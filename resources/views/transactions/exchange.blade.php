@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Exchanges</span>     <span class="text-success"></h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($data) == 0)
               <strong class="text-danger">No Exchange Record Yet</strong>
           
               @else

          
           <div class="table-responsive" id="deposits-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Username</th><th>Amount</th><th>Phone Number</th><th>Currency</th><th>Status</th><th></th></tr>
           </thead>
           <tbody>
               @foreach($data as $deposit)
               <tr><td>{{ucwords($deposit->user->username)}}</td>
               <td>{{$deposit->amount}}</td>
               <td>{{$deposit->phone_number}}</td>
               <td>{{$deposit->currency_to}}</td>
               <td>
                @if($deposit->status == true)
                <strong class="text-success">Completed</strong>
                @else
                <strong class="text-danger">Pending</strong>
                @endif
               </td>
                 
               <td>
                @if($deposit->status == false)
                   <form method="post" action="{{url("/admin/updateexchangestatus")}}">
                       @csrf
                       <input type="hidden" name="id" value="{{$deposit->id}}" />
                       <button method="submit" class="btn btn-sm btn-success" name="delete_deposit_btn"><span class="fa fa-check"></span> Update</button>
                   </form>
                   @endif
               </td>
             
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
           {{$data->links()}}
           </div>
           @endif
   
       </div>
      </div>
   



@include("layouts.adminfooter")
@endsection