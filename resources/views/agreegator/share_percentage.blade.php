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
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Dropifypay Agreegators Share Percentage
    </span>  </h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
               @if(Session::get("success"))
                <div class="alert alert-success">
                 <strong class="text-success">{{Session::get("success")}}</strong>
                </div>
               @endif
             

           <div class="table-responsive" id="deposits-content">
           <table class="table table-striped dt-responsive nowrap w-100">
           <thead>
               <tr><th>Transaction Type</th><th>Agreegator Share</th><th></th></tr>
           </thead>
           <tbody>
               @foreach($transaction_shares as $deposit)
            
               <tr><td>{{ucwords($deposit->transaction_type)}}</td>
               <td>{{$deposit->agreegator_percentage}}%</td>
               
                <td>
                    <form method="post" action="{{url("/updateagreegatortransactionshare")}}">
                        @csrf
                        <input type="hidden" name="share_percentage_id" value="{{$deposit->id}}" />
                         <input type="number" step='any' placeholder="{{$deposit->agreegator_percentage}}%" name="agreegator_percentage" class="form-control" />
                          <br />
                         <input type="submit" name="delete_agreegator_btn" class="btn btn-sm btn-success" value="Update" />
                       
                    </form>
                   
               </td>
               </tr>
               
               
           
           @endforeach
           </tbody>
           </table>
           <br />
   
        
           </div>
      
   
       </div>
      </div>
   

   


@include("layouts.adminfooter")
@endsection