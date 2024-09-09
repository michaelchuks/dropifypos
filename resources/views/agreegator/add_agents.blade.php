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
                                <h4 class="page-title">Assign Agents {{$agreegator->name}} <a href="{{url("agreegatoragents/$agreegator->id")}}" class="btn btn-sm btn-danger">Return</a></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                    <p class="text-muted font-14">
                                      Assign Agents Below by checking the boxes
                                    </p>

                                  


                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title"></h4>
                                   

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
                                            <form  method="post" action="{{url("/assignagreegatoragents")}}">
                                                @csrf
                                                 @foreach($users as $user)
                                                 <p><strong>{{$user->fullname}} - {{$user->city}} ,{{$user->state}} state</strong> <input type="checkbox" name="agents[]" value="{{$user->id}}" /></p>
                                                 @endforeach
                                                
                                                <input type="hidden" name="agreegator_id" value="{{$agreegator->id}}" />

                                                <button  type="submit" name="wallet_Agreegator_btn" class="btn btn-primary">Assign Agents</button>
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