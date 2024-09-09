@extends("layouts.pageheader")
@section("title") Create Agent @endsection
@section("content")
@include("layouts.pagenavigation")

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
                                <h4 class="page-title">Create Agent</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" style="display:flex;align-items:center;justify-content:space-between;"><span>New Agent</span> <a href="{{url("/users")}}" class="btn btn-sm btn-success">Agents</a></h4>
                                    <p class="text-muted font-14">
                                       Enter New Agent Details Below
                                    </p>

                                  
                                    <div class="alert alert-success">
                                        <strong class="text-success">{{Session::get("success")}}</strong>
                                       </div>
                                       @endif

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
                                        <strong class="text-light">{{Session::get("success")}}</strong>
                                      </div>
                                      @endif
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="form-row-preview">
                                            <form  method="post" action="{{route("admin.users.store")}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Name</label>
                                                        <input type="text" name="fullname" class="form-control" id="inputEmail4" placeholder="Full Name" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Email</label>
                                                        @error("email")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                        <input type="email" class="form-control" name="email" id="inputPassword4" placeholder="Email" required>
                                                    </div>
                                                </div>


                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Phone</label>
                                                        @error("phone")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                        <input type="tel" name="phone" class="form-control" id="inputEmail4" placeholder="Phone No" required>
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
                                                        <input type="text" name="city" class="form-control" id="inputEmail4" placeholder="City" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Address</label>
                                                        <input type="text" name="address" class="form-control" required placeholder="Address" required />
                                                    </div>
                                                </div>


                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">BVN</label>
                                                        <input type="text" name="BVN" class="form-control" id="inputEmail4" placeholder="Bank Verification Number" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">NIN</label>
                                                        <input type="NIN" name="NIN" class="form-control" required placeholder="NIN" required />
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAddress" class="form-label">Passport Photograph <small><strong>(a png,jpg,jpeg image not more than 3mb)</strong></small></label>
                                                    @error("profile_image")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                    <input type="file" name="profile_image" class="form-control" id="inputAddress" placeholder="Profile Image" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAddress2" class="form-label">Password</label>
                                                    <input type="passsword" class="form-control" id="inputPassword4" placeholder="Password" required>
                                                </div>

                                              

                                                <button type="submit" name="create_user_btn" class="btn btn-primary">Sign in</button>
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



@include("layouts.pagefooter")
@endsection