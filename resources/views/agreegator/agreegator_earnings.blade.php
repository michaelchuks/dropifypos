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
        <h4 class="header-title" style="display:flex;align-items:center;justify-content:space-between;"><span> List of all Earnings By {{$agreegator->name}}</span>
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
               @if(count($earnings) == 0)
               <strong class="text-danger">No Earnings yet</strong>
           
               @else

           <div class="table-responsive" id="deposits-content">
            <table  class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th></th>
                        <th>Agent Name</th>
                        <th>Transaction</th>
                        <th>Earning</th>
                        <th>Date</th>
                       
                    </tr>
                </thead>
            
            
                <tbody id="tbody">
                    @foreach($earnings as $data)
                    @php
                    $timestamp = strtotime($data->created_at) ;
                    $day = date("l",$timestamp);
                    $month = date("F",$timestamp);
                    $year = date("Y",$timestamp);
                    $time = date("h:i:A",$timestamp);
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                       <td>{{$data->name}}</td>
                       <td>{{$data->earned_from}}</td>
                       <td>&#8358;{{$data->amount}}</td>
                       <td>{{$time}} {{$day}} {{$month}} {{date("d",$timestamp)}} {{$year}}</td>
                  
                    </tr>
                    @endforeach
                   
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Agent Name</th>
                        <th>Transaction</th>
                        <th>Earning</th>
                        <th>Date</th>
                        
                        
                    </tr>
                </tfoot>
            </table>
            <br />
            
            {{$earnings->links()}}
   
        
           </div>
           @endif
   
       </div>
      </div>
   

   


@include("layouts.adminfooter")
@endsection