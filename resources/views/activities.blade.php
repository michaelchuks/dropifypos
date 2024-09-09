@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")
<style>
    .form-layout{
        display:flex !important;
        align-items:center !important;
        justify-content: space-between !important;
    }

    .form-layout .layout-content{
        display:grid !important;
    }
    </style>
<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Dropifypay Pos Activities for {{$data}}</span> <span class="text-success">Total: {{$total}}</span>
   @if($type == "day" && count($activities) > 0)
    <a  href="{{url("/dayanalytics")}}" class="btn btn-sm btn-primary">View Analytic</a>
   @endif

   @if($type == "week" && count($activities) > 0)
   <a  href="{{url("/weekanalytics")}}" class="btn btn-sm btn-primary">View Analytic</a>
  @endif


  @if($type == "month" && count($activities) > 0)
  <a  href="{{url("/monthanalytics")}}" class="btn btn-sm btn-primary">View Analytic</a>
 @endif
</h6>
    @if($data == "all")
   @php
      $admin = \App\Models\Admin::first();
        $timestamp = strtotime($admin->created_at);
        $end_year = date("Y");
        $start_year = date("Y");
        $years_array = array();
        for($year = $start_year; $year >= $end_year;$year--){
            array_push($years_array,$year);
        }
        $day_array = ["01","02","03","04","05","06","07","08","09","10","11","12","13",'14','14','16',
        "17","18",'19','20','21','22','23','24','25','26','27','28','29','30','31'
    ];

        $month_array = ["January","February","March","April","May","June","July","August","September",
        "October","November","December"];
    @endphp
    @endif
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
         @if($data == "all")
         <form method="post">
            @csrf
         <div class="form-layout">
            <div class="layout-content">
             <label>Year</label>
             <select name="year">
             <option value="all">All</option>
             @foreach($years_array as $year)
             <option value="{{$year}}">{{$year}}</option>
             @endforeach
             </select>
            </div>

              <div class="layout-content">
                <label>Month</label>
                <select name="month">
                <option value="all">All</option>
                @foreach($month_array as $month)
                <option value="{{$month}}">{{$month}}</option>
                @endforeach
                </select>
               </div>


               <div class="layout-content">
                <label>Day</label>
                <select name="day">
                <option value="all">All</option>
                @foreach($day_array as $day)
                <option value="{{$day}}">{{$day}}</option>
                @endforeach
                </select>
               </div>

               <div class="layout-content">
                 <input type="submit" class="btn btn-sm btn-success" value="Search Data" />
               </div>

         </div>

         </form>
         <br />
         @endif
           <div class="table-responsive" id="deposits-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><th>Agent Name</th><th>Transaction Type</th><th>Amount</th><th>Date And Time</th><th></th></tr>
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
               <tr><td>{{ucwords($data->user->fullname)}}</td>
                <td>{{$data->activity_type}}</td>
               <td>&#8358;{{$data->amount}}</td>
               <td>{{$time}} {{$day}} {{$month}} {{date("d",$timestamp)}} {{$year}}</td>
               <td><a href="{{url("/activity/$data->id")}}" class="btn btn-sm btn-success">View Details</a>
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