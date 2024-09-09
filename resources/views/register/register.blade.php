@extends("layouts.adminheader")
@section('content')

<style>
    body{
        color:black !important;
        font-size:.8rem !important;
    }

    .page-title-box{
        background-color:black !important;
        color:White !important;
        display:flex !important;
        align-items:center !important;
        height:8vh !important;
        padding:20px !important;
    }

    .form-control{
        font-size:.8rem !important;
    }
    </style>



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
                                <br />
                                <h4 class="page-title">Register Details Below</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" style="display:flex;align-items:center;justify-content:space-between;"><span>New Agent</span></h4>
                                    <p class="text-muted font-14">
                                       Enter New Agent Details Below
                                    </p>

                                  


                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Agent Details</h4>
                                    <p class="text-muted font-14">
                                      Correct agent details are neccessary
                                    </p>

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
                                            <form  method="post" action="{{url("/registeragent")}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Name</label>
                                                        <input type="text" value="{{old("fullname")}}" name="fullname" class="form-control" id="inputEmail4" placeholder="Full Name" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Email</label>
                                                        @error("email")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                        <input type="email" value="{{old("email")}}" class="form-control" name="email" id="inputPassword4" placeholder="Email" required>
                                                    </div>
                                                </div>


                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Phone</label>
                                                        @error("phone")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                        <input type="tel" name="phone" value="{{old("phone")}}" class="form-control" id="inputEmail4" placeholder="Phone No" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">State</label>
                                                        <select name="state" class="form-control">
                                                            @foreach($states as $state)
                                                             <option value="{{$state->state}}">{{$state->state}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">City</label>
                                                        <input type="text" value="{{old("city")}}" name="city" class="form-control" id="inputEmail4" placeholder="City" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Address</label>
                                                        <input type="text" value="{{old("address")}}" name="address" class="form-control" required placeholder="Address" required />
                                                    </div>
                                                </div>


                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">BVN</label>
                                                        <input type="text" name="BVN" value="{{old("BVN")}}" class="form-control" id="inputEmail4" placeholder="Bank Verification Number" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">NIN</label>
                                                        <input type="text" name="NIN" value="{{old("NIN")}}" class="form-control" required placeholder="NIN" required />
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAddress" class="form-label">Passport Photograph <small><strong>(a png,jpg,jpeg image not more than 3mb)</strong></small></label>
                                                    @error("profile_image")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                    <input type="file" name="profile_image"  class="form-control" id="inputAddress" placeholder="Profile Image" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAddress2" class="form-label">Password</label>
                                                    @error("password")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                    <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password" required>
                                                    
                                                    
                                                  

                                                <br />

                                                <button type="submit" name="register_agent_btn" class="btn btn-primary">Register</button>
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