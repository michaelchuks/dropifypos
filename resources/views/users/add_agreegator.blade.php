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
                                <h4 class="page-title">Add Agreegator to {{$user->name}}</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                    <p class="text-muted font-14">
                                       Add New Agent Agreegator Below
                                    </p>

                                  


                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Agent Agreegator</h4>
                                   

                                      @if(Session::get("success"))
                                      <div class="alert alert-success">
                                        <strong class="text-success">{{Session::get("success")}}</strong>
                                      </div>
                                      @endif
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="form-row-preview">
                                            <form  method="post" action="{{url("/saveuseragreegator")}}">
                                                @csrf
                                                <div class="row g-2">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputEmail4" class="form-label">Name</label>
                                                        <input type="text" value="{{old("fullname")}}" name="fullname" class="form-control" id="inputEmail4" placeholder="{{$user->fullname}}" readonly>

                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="inputPassword4" class="form-label">Select Agreegator</label>
                                                      
                                                        <select  class="form-control" name="agreegator_id">
                                                            @foreach($agreegators as $agreegator)
                                                            @php
                                                              $total_agents = \App\Models\User::where('agreegator_id',"=",$agreegator->id)->count();  
                                                            @endphp
                                                            <option value="{{$agreegator->id}}">{{$agreegator->name}} with {{$total_agents}} agents</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="agent_id" value="{{$user->id}}" />

                                                <button onclick="return confirm('are you sure you want to add this agreegator to this agent')" type="submit" name="map_agent_btn" class="btn btn-primary">Add Agreegator</button>
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