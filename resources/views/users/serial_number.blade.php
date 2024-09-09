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
                                <h4 class="page-title">Map Agent with Pos Serial Number</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                    <p class="text-muted font-14">
                                       Enter New Agent Pos Serial Number Below
                                    </p>

                                  


                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Agent Serial</h4>
                                    <p class="text-muted font-14">
                                      Correct agent Pos Serial Number details are neccessary
                                    </p>

                                      @if(Session::get("success"))
                                      <div class="alert alert-success">
                                        <strong class="text-success">{{Session::get("success")}}</strong>
                                      </div>
                                      @endif
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="form-row-preview">
                                            <form  method="post" action="{{url("/processagentmapping")}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Name</label>
                                                        <input type="text" value="{{old("fullname")}}" name="fullname" class="form-control" id="inputEmail4" placeholder="{{$user->fullname}}" readonly>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Pos Serial Number</label>
                                                        @error("pos_serial_number")<small><strong class="text-danger">{{$message}}</strong></small><br />@enderror
                                                        <input type="text" value="{{old("serial_number")}}" class="form-control" name="pos_serial_number" id="inputPassword4" placeholder="Pos Serial Number" required>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="user_id" value="{{$user->id}}" />

                                                <button onclick="return confirm('are you sure you want to Map agent')" type="submit" name="map_agent_btn" class="btn btn-primary">Map Agent</button>
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