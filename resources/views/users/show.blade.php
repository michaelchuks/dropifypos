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
                                    <ol class="breadcrumb m-0">
                                        @if(session()->get("section") == "agent")
                                        <li class="breadcrumb-item"><a href="{{url("agents")}}">Back</a></li>
                                        @elseif(session()->get("section") == "agreegator")
                                        <li class="breadcrumb-item"><a href="{{url("agreegatoragents/$user->agreegator_id")}}">Back</a></li>
                                        @endif
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{$user->fullname}}</a></li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Profile</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->


                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Profile -->
                            <div class="card bg-primary">
                                <div class="card-body profile-user-box">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-lg">
                                                        <img src="{{asset("$user->profile_image")}}" alt="" class="rounded-circle img-thumbnail">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <h4 class="mt-1 mb-1 text-white">{{$user->fullname}}</h4>
                                                        @if($business_details != null)
                                                        <p class="font-13 text-white-50">{{ucwords($business_details->business_name)}}</p>
                                                       
                                                        @else
                                                        <p class="font-13 text-white-50">Regsitered Agent</p>
                                                       
                                                        @endif
                                                        <ul class="mb-0 list-inline text-light">
                                                            <li class="list-inline-item me-3">
                                                                <h5 class="mb-1 text-white"> &#8358; {{$activities_sum}}</h5>
                                                                <p class="mb-0 font-13 text-white-50">Total Revenue</p>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <h5 class="mb-1 text-white">{{$activities_count}}</h5>
                                                                <p class="mb-0 font-13 text-white-50">Number of Transactions</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end col-->

                                        <div class="col-sm-4">
                                            <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                                <a type="button" class="btn btn-light" href="{{url("editprofile/$user->id")}}">
                                                    <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                                                </a>
                                            </div>
                                        </div> <!-- end col-->
                                    </div> <!-- end row -->

                                </div> <!-- end card-body/ profile-user-box-->
                            </div><!--end profile/ card -->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-xl-4">
                            <!-- Personal-Information -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">Agent Information</h4>
                                  

                                    <hr />

                                    <div class="text-start">
                                        <p class="text-muted"><strong>Full Name :</strong> <span class="ms-2">{{ucwords($user->fullname)}}</span></p>

                                        <p class="text-muted"><strong>Mobile :</strong><span class="ms-2">{{$user->phone}}</span></p>

                                        <p class="text-muted"><strong>Email :</strong> <span class="ms-2">{{$user->email}}</span></p>

                                        <p class="text-muted"><strong>Location :</strong> <span class="ms-2">{{$user->address}}, {{$user->city}}</span></p>

                                        <p class="text-muted"><strong>State:</strong>
                                            <span class="ms-2">{{$user->state}} </span>
                                        </p>

                                        @if($user->pos_serial_number != null)
                                        <p class="text-muted"><strong>Pos SerialNo :</strong> <span class="ms-2">{{$user->pos_serial_number}}</span></p>
                                        @endif

                                        <p class="text-muted"><strong>NIN :</strong> <span class="ms-2">{{$user->NIN}}</span></p>

                                        <p class="text-muted"><strong>BVN :</strong> <span class="ms-2">{{$user->BVN}}</span></p>
                                        <p class="text-muted"><strong>IP Address :</strong> <span class="ms-2">{{$user->ip_address}}</span></p>
                                        @if($user->agreegator_id != 0)
                                        <p class="text-muted"><strong>Agreegator :</strong> <span class="ms-2">{{$user->agreegator->name}}</span></p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <!-- Personal-Information -->


                        </div> <!-- end col-->

                        <div class="col-xl-8">

                            <!-- Chart-->
                            <div class="card">
                                <div class="card-body">
                                     <div class="row">
                                        <div class="col-md-6">
                                    <h4 class="header-title mb-3">Business Details</h4>
                                     @if($business_details != null)
                                     <p>Business Name : {{$business_details->business_name}}</p>
                                     <p>RC Number : {{$business_details->RC_number}}</p>
                                     <p>TIN Number : {{$business_details->TIN_number}}</p>
                                     <h6>CAC Certificate</h6>
                                     <img src="{{asset("$business_details->CAC_certificate")}}" style="width:200px;height:200px;border-radius:10px;" />
                                     @else
                                      <p>No Business Details Registered yet</p>
                                     @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($user->accountDetails != null)
                                            <h4 class="header-title mb-3">Account Details</h4>
                                          
                                            <p>Account Name : {{$user->accountDetails->account_name}}</p>
                                            <p>Account Number : {{$user->accountDetails->account_number}}</p>
                                            <p>Bank : {{$user->accountDetails->bank_name}}</p>
                                            @endif
                                        </div>
                                     </div>

                                </div>
                            </div>
                            <!-- End Chart-->

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="card tilebox-one">
                                        <div class="card-body">
                                            <i class="ri-shopping-basket-2-line float-end text-muted"></i>
                                            <h6 class="text-muted text-uppercase mt-0">Transactions</h6>
                                            <h2 class="m-b-20" style="font-size:.9rem;font-weight:bold;">{{$activities_count}}</h2>
                                            <a class="badge bg-primary text-light" href="{{url("agenttransactions/$user->id")}}">View Transactions</a>
                                        </div> <!-- end card-body-->
                                    </div> <!--end card-->
                                </div><!-- end col -->

                                <div class="col-sm-3">
                                    <div class="card tilebox-one">
                                        <div class="card-body">
                                            <i class="ri-shopping-basket-2-line float-end text-muted"></i>
                                            <h6 class="text-muted text-uppercase mt-0">Transfers</h6>
                                            <h2 class="m-b-20" style="font-size:.9rem;font-weight:bold;">&#8358;{{$transfer_sum}}</h2>
                                            <a class="badge bg-success text-light" href="{{url("agenttransfers/$user->id")}}">View</a>
                                        </div> <!-- end card-body-->
                                    </div> <!--end card-->
                                </div><!-- end col -->

                                <div class="col-sm-3">
                                    <div class="card tilebox-one">
                                        <div class="card-body">
                                            <i class="ri-archive-line float-end text-muted"></i>
                                            <h6 class="text-muted text-uppercase mt-0">Deposits</h6>
                                            <h2 class="m-b-20" style="font-size:.9rem;font-weight:bold;">&#8358; <span>{{$deposit_sum}}</span></h2>
                                            <a class="badge bg-danger text-light" href="{{url("agentdeposits/$user->id")}}">View</a>
                                        </div> <!-- end card-body-->
                                    </div> <!--end card-->
                                </div><!-- end col -->

                                <div class="col-sm-3">
                                    <div class="card tilebox-one">
                                        <div class="card-body">
                                            <i class="ri-vip-diamond-line float-end text-muted"></i>
                                            <h6 class="text-muted text-uppercase mt-0">Withdrawals</h6>
                                            <h2 class="m-b-20" style="font-size:.9rem;font-weight:bold;">&#8358; {{$withdrawal_sum}}</h2>
                                            <a class="badge bg-primary text-light" href="{{url("agentwithdrawals/$user->id")}}">View</a>
                                        </div> <!-- end card-body-->
                                    </div> <!--end card-->
                                </div><!-- end col -->

                            </div>
                            <!-- end row -->


                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Latest Transactions</h4>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Type</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($latest_activities as $data)
                                                <tr>
                                                    <td>{{$data->activity_type}}</td>
                                                    <td>{{$data->created_at}}</td>
                                                    <td><span class="badge bg-primary" style="color:white;">successful</span></td>
                                                    <td>&#8358;{{$data->amount}}</td>
                                                </tr>
                                               @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end table responsive-->
                                </div> <!-- end col-->
                            </div> <!-- end row-->

                        </div>
                        <!-- end col -->

                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->



@include("layouts.adminfooter")
@endsection