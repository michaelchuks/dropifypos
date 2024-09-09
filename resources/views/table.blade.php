@extends("layouts.tableheader")
@section("title") Active Users @endsection
@section('content')
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
                                <h4 class="page-title"><span>Active Users</span></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" style="display:flex;align-items:center;justify-content:space-between;"><span>Active Agents Records</span>  <a href="{{route("admin.users.create")}}" class="btn btn-sm btn-success">Create Agent</a></h4>
                                     
                                    <p class="text-muted font-14" style="display:flex;align-items:center;justify-content:space-between;">
                                      <span> List of all active agents registered with dropifypay</span>
                                       <input type="text" id="search-term" onkeyup="search()" placeholder="Search by name,city or state" style="width:200px;" />
                                      
                                      
                                    </p>

                                    <div class="alert alert-success">
                                        <strong class="text-success">{{Session::get("success")}}</strong>
                                       </div>
                                       @endif
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-datatable-preview">
                                            <table  class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Address</th>
                                                        <th>City</th>
                                                        <th>State</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>


                                                <tbody id="tbody">
                                                    @foreach($users as $data)
                                                    <tr>
                                                       <td>{{$data->fullname}}</td>
                                                       <td>{{$data->email}}</td>
                                                       <td>{{$data->phone}}</td>
                                                       <td>{{$data->address}}</td>
                                                       <td>{{$data->city}}</td>
                                                       <td>{{$data->state}}</td>
                                                       <td><a href="{{url("user/$data->id")}}" class="btn btn-info btn-sm">View</a></td>
                                                       <td>
                                                        <form method="post" action="{{url("/suspenduser")}}">
                                                            @csrf
                                                         <input type="hidden" name="user_id" value="{{$data->id}}"  />
                                                         <input type="submit" name="suspend_user_btn" class="btn btn-sm btn-danger" onclick="return confirm('are you sure you want to suspend agent')" value="Suspend Agent" />
                                                        </form></td>
                                                    </tr>
                                                    @endforeach
                                                   
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Address</th>
                                                        <th>City</th>
                                                        <th>State</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br />

                                            {{$users->links()}}
                                        </div> <!-- end preview-->

                                       
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->
                </div> <!-- container -->

            </div> <!-- content -->


            <script>
                function search(){
                    var tbody = document.getElementById("tbody");
                    var searchTerm = document.getElementById("search-term").value;
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                           tbody.innerHTML = this.responseText;
                        }
                    }

                    xhttp.open("GET","searchuser?term="+searchTerm,true);
                    xhttp.send();
                }

                </script>

@include("layouts.tablefooter")
@endsection


















