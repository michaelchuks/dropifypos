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
        <h4 class="header-title" style="display:flex;align-items:center;justify-content:space-between;"><span>Active Agents Records</span>
            <a href="{{route("admin.users.create")}}" class="btn btn-sm btn-success">Create Agent</a></h4>
            <p class="text-muted font-14" style="display:flex;align-items:center;justify-content:space-between;">
              <span> List of all active agents registered with dropifypay</span>
               <input type="text" id="search-term" onkeyup="search()" placeholder="Search by name,city or state" style="width:200px;" />
            </p>
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
                        <th>Agreegator</th>
                        <th>Mapping Status</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
                       @if($data->agreegator == null)
                       <td>No Agreegator</td>
                       @else
                       <td>{{$data->agreegator->name}}</td>
                       @endif
                       <td>
                        @if($data->Mapping_status == "unmapped")
                        <span class="text-danger">Unmapped</span>
                        @else
                        <span class="text-success">Mapped</span>
                        @endif
                       </td>
                       <td><a href="{{url("user/$data->id")}}" class="btn btn-info btn-sm">View</a></td>
                        <td><a href="{{url("agentwallet/$data->id")}}" class="btn btn-sm btn-success">Manage Wallet</a></td>
                       <td>
                        @if($data->Mapping_status == "unmapped")
                        <a href="{{url("/mapagent/$data->id")}}" type="button" class="btn btn-sm btn-success">Map Agent</a>
                        @else
                         <form method="post" action="{{url("/unmapagent")}}">
                            @csrf
                            <input type="hidden" name="agent_id" value="{{$data->id}}"/> 
                           <input type="submit" name="unmap_agent_btn" value="Unmap Agent" class='btn btn-sm btn-secondary' onclick="return confirm('are you sure you want to unmap agent')" />
                         </form>
                        @endif
                        <td>
                            @if($data->agreegator == null)
                            <td><a href="{{url("/addagreegator/$data->id")}}" class="btn btn-sm btn-primary">Add Agreegator</a</td>
                            @else
                            <td>
                                <form method="post" action="{{url("/removeagreegator")}}">
                                    @csrf
                                    <input type="hidden" name="agent_id" value="{{$data->id}}" />
                                    <input type="submit" class="btn btn-sm btn-normal" style="background-color:purple;color:white" onclick="return confirm('are you sure you want to remove agent agreegator')" value="Remove Agreegator" />
                                </form>
                            </td>
                            @endif
                       <td>
                        <form method="post" action="{{url("/suspendagent")}}">
                            @csrf
                         <input type="hidden" name="agent_id" value="{{$data->id}}"  />
                         <input type="submit" name="suspend_user_btn" class="btn btn-sm btn-danger" onclick="return confirm('are you sure you want to suspend agent')" value="Suspend Agent" />
                        </form></td>
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
                        <th>Agreegator</th>
                        <th>Mapping Status</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
<script>
    function search(){
        var tbody = document.getElementById("tbody");
        var searchTerm = document.getElementById("search-term").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
               tbody.innerHTML = this.responseText;
            }
        }

        xhttp.open("GET","searchuser?term="+searchTerm,true);
        xhttp.send();
    }

    </script>
@endsection