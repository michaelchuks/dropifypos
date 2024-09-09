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
        <h4 class="header-title" style="display:flex;align-items:center;justify-content:space-between;"><span> List of all active agents registered with {{$agreegator->name}}</span>
            <a href="{{url("/addagreegatoragents/$agreegator->id")}}" class="btn btn-success btn-sm">Assign Agents</a>
            <a href="{{url("/agreegators")}}" class="btn btn-primary btn-sm">Agreegators</a>
        </h4>
           
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif

               @if(Session::get("error"))
               <div class="alert alert-danger">
                <strong class="text-danger">{{Session::get("error")}}</strong>
               </div>
              @endif
               @if(count($users) == 0)
               <strong class="text-danger">No Agent added yet</strong>
           
               @else

           <div class="table-responsive" id="deposits-content">
            <table  class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Pos Serial No</th>
                        <th>Wallet Balance</th>
                        <th></th>
                       
                    </tr>
                </thead>
            
            
                <tbody id="tbody">
                    @foreach($users as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                       <td>{{$data->fullname}}</td>
                       <td>{{$data->email}}</td>
                       <td>{{$data->phone}}</td>
                       <td>{{$data->address}}</td>
                       <td>{{$data->city}}</td>
                       <td>{{$data->state}}</td>
                       <td>{{$data->pos_serial_number}}</td>
                       <td>&#8358;{{$data->wallet}}</td>
                       <td><a href="{{url("user/$data->id")}}" class="btn btn-info btn-sm">View</a></td>
                      
                    </tr>
                    @endforeach
                   
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Pos Serial No</th>
                        <th>Wallet Balance</th>
                       
                        <th></th>
                        
                    </tr>
                </tfoot>
            </table>
            <br />
            
            {{$users->links()}}
   
        
           </div>
           @endif
   
       </div>
      </div>
   

   


@include("layouts.adminfooter")
@endsection