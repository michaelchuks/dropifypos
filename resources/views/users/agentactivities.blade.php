@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")
<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Dropifypay Pos Activities for {{$data}}</span>     
     <a href="{{url("user/$id")}}" class="btn btn-sm btn-danger">Back to Profile</a>
    <span class="text-success">Total: &#8358;{{$total}}</h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($activities) == 0)
               <strong class="text-danger">No Activities yet</strong>
           
            @else
           <div class="table-responsive" id="deposits-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Transaction Type</th><th>Amount</th><th>Date And Time</th></tr>
           </thead>
           <tbody>
               @foreach($activities as $data)
               @php
               $timestamp = strtotime($data->created_at) ;
               $day = date("l",$timestamp);
               $month = date("F",$timestamp);
               $year = date("Y",$timestamp);
               $time = date("h:i:A",$timestamp);
               @endphp
               <tr>
                <td>{{$data->activity_type}}</td>
               <td>&#8358;{{$data->amount}}</td>
               <td>{{$time}} {{$day}} {{$month}} {{date("d",$timestamp)}} {{$year}}</td>
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
           {{$activities->links()}}
           </div>
           @endif
   
       </div>
      </div>
   

      <script>
        function getActivities(){
         var username = document.getElementById("username").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                
                document.getElementById("deposits-content").innerHTML = this.responseText;
            }
        }
        
        xhttp.open("GET","searchactivity?username="+username,true);
        xhttp.send();
        }
        
        </script>


@include("layouts.adminfooter")
@endsection