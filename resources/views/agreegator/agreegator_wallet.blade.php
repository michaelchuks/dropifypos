@extends("layouts.adminheader")
@section('content')
@include("layouts.adminavigation")

   <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                  
                                </div>
                                <h4 class="page-title">Wallet Balance For {{$agreegator->name}} &#8358;{{$agreegator->wallet}}</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                    <p class="text-muted font-14">
                                       Manage Agreegator Wallet Below
                                    </p>

                                  


                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Agreegator Wallet Balance &#8358;{{$agreegator->wallet}}</h4>
                                   

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
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="form-row-preview">
                                            <form  method="post" action="{{url("/manageagreegatorwallet")}}">
                                                @csrf
                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Amount</label>
                                                        <input type="number" step="any" value="{{old("amount")}}" name="amount" class="form-control" id="inputEmail4" >

                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Select Transaction Type</label>
                                                      
                                                        <select  class="form-control" name="transaction_type">
                                                           
                                                            <option value="credit">Credit</option>
                                                            <option value="debit">debit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="agreegator_id" value="{{$agreegator->id}}" />

                                                <button  type="submit" name="wallet_Agreegator_btn" class="btn btn-primary">Process Transaction</button>
                                            </form>
                                        </div> <!-- end preview-->

                                     
                                    </div> <!-- end tab-content-->

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->



@include("layouts.adminfooter")
@endsection