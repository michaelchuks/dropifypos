@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")
<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Deposit Records for {{$data}}</span>    
    <a href="{{url("user/$id")}}" class="btn btn-sm btn-danger">Back to Profile</a>
    <span class="text-success">Total: {{$total}}</h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($deposits) == 0)
               <strong class="text-danger">No Deposits Yet</strong>
           
               @else

          
           <div class="table-responsive" id="deposits-content">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           <thead>
               <tr><<th>Amount</th><th>Reference Id</th><th>Date</th><th></th></tr>
           </thead>
           <tbody>
               @foreach($deposits as $deposit)
               @php
               $timestamp = strtotime($deposit->created_at) ;
               $day = date("l",$timestamp);
               $month = date("F",$timestamp);
               $year = date("Y",$timestamp);
               $time = date("h:i:A",$timestamp);
               @endphp
               <tr>
               <td>{{$deposit->amount}}</td>
               <td>{{$deposit->reference}}</td>
               <td>{{$time}} {{$day}} {{$month}} {{date("d",$timestamp)}} {{$year}}</td>
    
               <td>
                   <form method="post" action="{{url("/deletedeposit")}}">
                       @csrf
                       <input type="hidden" name="deposit_id" value="{{$deposit->id}}" />
                       <button method="submit" class="btn btn-sm btn-danger" name="delete_deposit_btn"><span class="fa fa-trash"></span> Delete</button>
                   </form>
               </td>
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
           {{$deposits->links()}}
           </div>
           @endif
   
       </div>
      </div>
   

      <script>
        function getDeposits(){
         var username = document.getElementById("username").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                
                document.getElementById("deposits-content").innerHTML = this.responseText;
            }
        }
        
        xhttp.open("GET","searchdeposit?username="+username,true);
        xhttp.send();
        }
        
        </script>


@include("layouts.adminfooter")
@endsection