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
                                <h4 class="page-title">Update Agent Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" style="display:flex;align-items:center;justify-content:space-between;"><span>New Agent</span> <a href="{{url("/user/$user->id")}}" class="btn btn-sm btn-success">Back to profile</a></h4>
                                    <p class="text-muted font-14">
                                      Update Agent Details Below
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
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="form-row-preview">
                                            <form  method="post" action="{{route("admin.users.update")}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Name</label>
                                                        <input type="text" value="{{$user->fullname}}" name="fullname" class="form-control" id="inputEmail4" placeholder="Full Name" >
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Email</label>
                                                        @error("email")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                        <input type="email" value="{{$user->email}}" class="form-control" name="email" id="inputPassword4" placeholder="Email" >
                                                    </div>
                                                </div>


                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Phone</label>
                                                        @error("phone")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                        <input type="tel" name="phone" value="{{$user->phone}}" class="form-control" id="inputEmail4" placeholder="Phone No" >
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">State</label>
                                                        <select name="state" class="form-control">
                                                            <option value="{{$user->state}}">{{$user->state}}</option>
                                                            @foreach($states as $state)
                                                            @if($state->state != $user->state)
                                                             <option value="{{$state->state}}">{{$state->state}}</option>
                                                             @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">City</label>
                                                        <input type="text" value="{{$user->city}}" name="city" class="form-control" id="inputEmail4" placeholder="City" >
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Address</label>
                                                        <input type="text" value="{{$user->city}}" name="address" class="form-control"  placeholder="Address"  />
                                                    </div>
                                                </div>

                                               
                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">BVN</label>
                                                        <input type="text" name="BVN" value="{{$user->BVN}}" class="form-control" id="inputEmail4" placeholder="Bank Verification Number" >
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">NIN</label>
                                                        <input type="NIN" name="NIN" value="{{$user->NIN}}" class="form-control"  placeholder="NIN"  />
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="inputAddress" class="form-label">Passport Photograph <small><strong>(a png,jpg,jpeg image not more than 3mb)</strong></small></label>
                                                    @error("profile_image")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                    <input type="file" name="profile_image"  class="form-control" id="inputAddress" placeholder="Profile Image" >
                                                </div>

                                              
                                                 <input type="hidden" name="user_id" value="{{$user->id}}" />
                                              

                                                <button type="submit" name="update_user_btn" class="btn btn-primary">Update Agent</button>
                                            </form>
                                        </div> <!-- end preview-->

                                     
                                    </div> <!-- end tab-content-->



                                    <br />
                                      @if($business_details != null)
                                    <h6><strong> Update Business Details</strong></h6>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="form-row-preview">
                                            <form  method="post" action="{{route("admin.users.updatebusinessdetails")}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="inputAddress2" class="form-label">Business Name</label>
                                                    <input type="text" value="{{$business_details->business_name}}" class="form-control" id="inputPassword4" placeholder="Business Name" name="business_name" >
                                                </div>


                                                <div class="mb-3">
                                                    <label for="inputAddress" class="form-label">CAC Certificate <small><strong>(a png,jpg,jpeg image not more than 3mb)</strong></small></label>
                                                    @error("CAC_certificate")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                    <input type="file" name="CAC_certificate" class="form-control" id="inputAddress" placeholder="CAC" >
                                                </div>

                                                    <input type="hidden"  name="user_id" value="{{$user_id}}" />
                                                <div class="mb-3">
                                                    <label for="inputAddress2" class="form-label">RC Number(optional)</label>
                                                    <input type="text" value="{{$business_details->RC_number}}" class="form-control" id="inputPassword4" placeholder="RC Number" name="RC_number" >
                                                </div>
                                                  <input type="hidden" name="user_id" value="{{$user->id}}" />
                                                <button type="submit" name="update_business_btn" class="btn btn-primary">Update</button>
                                            </form>
                                        </div> <!-- end preview-->
                                    </div>
                                    @endif








                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->



@include("layouts.adminfooter")
@endsection