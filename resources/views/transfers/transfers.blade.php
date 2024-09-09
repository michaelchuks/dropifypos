@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")


<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Transfers</span>     <span class="text-success">Total: {{$total}}</h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
               @if(count($transfers) == 0)
               <strong class="text-danger">No Transfers Yet</strong>
           
               @else

            <input type="text" id="username" class="form-control" placeholder="Search User By Username" onkeyup="getTransfers()"/>
            <br />
            <div class="table-responsive" id="deposits-content">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr><th>Account Name</th><th>Account No</th><th>Bank</th><th>Amount</th><th>Transaction Charge</th><th>Reference Id</th><th>Date</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach($transfers as $deposit)
                    @php
                       $timestamp = strtotime($deposit->created_at) ;
                       $day = date("l",$timestamp);
                       $month = date("F",$timestamp);
                       $year = date("Y",$timestamp);
                       $time = date("h:i:A",$timestamp);
                    @endphp
                    <tr>
                     <td>{{$deposit->account_name}}</td>
                     <td>{{$deposit->account_number}}</td>
                     <td>{{$deposit->bank}}</td>
                    <td>&#8358;{{$deposit->amount}}</td>
                    <td>&#8358;{{$deposit->transaction_charge}}
                    <td>{{$deposit->reference}}</td>
                    <td>{{$time}} {{$day}} {{$month}} {{date("d",$timestamp)}} {{$year}}</td>
         
                    <td>
                        <form method="post" action="{{url("/deletetransfer")}}">
                            @csrf
                            <input type="hidden" name="transfer_id" value="{{$deposit->id}}" />
                            <button method="submit" class="btn btn-sm btn-danger" name="delete_transfer_btn"><span class="fa fa-trash"></span> Delete</button>
                        </form>
                    </td>
                    </tr>
                    
                    
                
                @endforeach
                </tbody>
                </table>
                <br />
        
                {{$transfers->links()}}
                </div>
           @endif
   
       </div>
      </div>
   

      <script>
        function getTransfers(){
         var username = document.getElementById("username").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                
                document.getElementById("transfer-content").innerHTML = this.responseText;
            }
        }
        
        xhttp.open("GET","searchtransfer?username="+username,true);
        xhttp.send();
        }
        
        </script>



@include("layouts.adminfooter")
@endsection