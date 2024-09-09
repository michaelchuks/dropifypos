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
                                       Enter {{$user->fullname}}  Business Details Below
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
                                        <strong class="text-light">{{Session::get("success")}}</strong>
                                      </div>
                                      @endif
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="form-row-preview">
                                            <form  method="post" action="{{route("admin.users.savebusinessdetails")}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="inputAddress2" class="form-label">Business Name</label>
                                                    <input type="text" class="form-control" id="inputPassword4" placeholder="Business Name" name="business_name" required>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="inputAddress" class="form-label">CAC Certificate <small><strong>(a png,jpg,jpeg image not more than 3mb)</strong></small></label>
                                                    @error("CAC_certificate")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                    <input type="file" name="CAC_certificate" class="form-control" id="inputAddress" placeholder="CAC" required>
                                                </div>

                                                    <input type="hidden"  name="user_id" value="{{$user_id}}" />
                                                <div class="mb-3">
                                                    <label for="inputAddress2" class="form-label">RC Number(optional)</label>
                                                    <input type="text" class="form-control" id="inputPassword4" placeholder="RC Number" name="RC_number" required>
                                                </div>

                                                <button type="submit" name="create_user_btn" class="btn btn-primary">Save</button>
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