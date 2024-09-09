@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")
<style>
    thead,tfoot{
        background-color:skyblue !important;
        color:black !important;
    }
    th{
        font-size:.7rem !important;
    }

    td{
        font-size:.7rem !important;
        font-weight:bold !important;
    }

    td .btn{
        font-size:.7rem !important;
    }
    </style>
<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Dropifypay Agreegators
    </span> <a href="{{route('admin.agreegator.create')}}" class="btn btn-sm btn-success">Create Agreegator</a> </h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($agreegators) == 0)
               <strong class="text-danger">No Agreegator added yet</strong>
           
               @else

           <div class="table-responsive" id="deposits-content">
           <table class="table table-striped dt-responsive nowrap w-100">
           <thead>
               <tr><th>Fullname</th><th>Email</th><th>Image</th><th>Agents</th><th>Wallet</th><th>Status</th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
           </thead>
           <tbody>
               @foreach($agreegators as $deposit)
               @php
               $total_agents = \App\Models\User::where("agreegator_id","=",$deposit->id)->count();
               $timestamp = strtotime($deposit->created_at) ;
               $day = date("l",$timestamp);
               $month = date("F",$timestamp);
               $year = date("Y",$timestamp);
               $time = date("h:i:A",$timestamp);
               @endphp
               <tr><td>{{ucwords($deposit->name)}}</td>
               <td>{{$deposit->email}}</td>
               <td><img src="{{asset("storage/agreegators/$deposit->image")}}" style="width:200px;height:180px;" /></td>
               <td>{{$total_agents}}</td>
                <td>&#8358;{{$deposit->wallet}}</td>
                <td>
                    @if($deposit->status == "active")
                    <span class="bg-success text-center text-light" style="border-radius:4px;padding:4px;">Active</span>
                    @else
                    <span class="bg-danger text-center text-light" style="border-radius:4px;padding:4px;">Suspended</span>
                    @endif
                </td>
               <td>{{$time}} {{$day}} {{$month}} {{date("d",$timestamp)}} {{$year}}</td>
                <td><a href="{{url("/agreegatoragents/$deposit->id")}}" class="btn btn-sm btn-success">View Agents</a></td>
                <td><a href="{{url("/agreegatorearnings/$deposit->id")}}" class="btn btn-sm btn-info">View Earnings</a></td>
                <td><a href="{{url("/agreegatorwallet/$deposit->id")}}" class="btn btn-sm btn-primary">Manage Wallet</a></td>
                <td>
                    <form method="post" action="{{url("/updateagreegatorstatus")}}">
                        @csrf
                        <input type="hidden" name="agreegator_id" value="{{$deposit->id}}" />
                        @if($deposit->status == "active")
                        <input type="submit" onclick="return confirm('are you sure you want to suspend agreegator')" name="suspend_agreegator_btn" class="btn btn-sm btn-secondary" value="Suspend" />
                        @else
                        <input onclick="return confirm('are you sure you want to reactivate agreegator')" type="submit" name="reactivate_agreegator_btn" class="btn btn-sm btn-warning text-dark" value="Reactivate" />
                        @endif
                    </form>
                <td>
                    <form method="post" action="{{url("/deleteagreegator")}}">
                        @csrf
                        <input type="hidden" name="agreegator_id" value="{{$deposit->id}}" />
                       
                        <input type="submit" name="delete_agreegator_btn" class="btn btn-sm btn-danger " value="Delete" />
                       
                    </form>
                   
               </td>
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
        
           </div>
           @endif
   
       </div>
      </div>
   

   


@include("layouts.adminfooter")
@endsection