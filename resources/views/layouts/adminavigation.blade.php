<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dropifypay</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{url("dashboard")}}">
                    <i class="fa fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

         
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefifty"
                    aria-expanded="true" aria-controls="collapseFifty">
                    <i class="fa fa-users" style='color:white;'></i>
                    <span><strong style='color:white;'>Agents</strong></span>
                </a>
                <div id="collapsefifty" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{url('agents')}}">Active Agents</a>
                        <a class="collapse-item" href="{{url('unmappedagents')}}">Unmapped Agents</a>
                        <a class="collapse-item" href="{{url('unactivatedagents')}}">Unactivated Agents</a>
                       <a class="collapse-item" href="{{url('suspendedagents')}}">Suspended Agents</a>
                       
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{url("subadmins")}}">
                    <i class="fa fa-users"></i>
                    <span>Subadmins</span></a>
            </li>


            <li class="nav-item active">
                <a class="nav-link" href="{{url("subadminroles")}}">
                    <i class="fa fa-certificate"></i>
                    <span>Subadmin Roles</span></a>
            </li>



            <li class="nav-item active">
                <a class="nav-link" href="{{url("agreegators")}}">
                    <i class="fa fa-users"></i>
                    <span>Agreegators</span></a>
            </li>


            <li class="nav-item active">
                <a class="nav-link" href="{{url("agreegatorroles")}}">
                    <i class="fa fa-certificate"></i>
                    <span>Agreegator Roles</span></a>
            </li>

             
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseten"
                    aria-expanded="true" aria-controls="collapseten">
                    <i class="fa fa-wallet" style='color:white;'></i>
                    <span><strong style='color:white;'>POS Activities</strong></span>
                </a>
                <div id="collapseten" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    
                        <a class="collapse-item" href="{{url('today')}}">Today Activities</a>
                       
                        <a class="collapse-item" href="{{url("week")}}">This Week</a>
                         
                       
                        <a class="collapse-item" href="{{url("month")}}">This Month</a>
                        <a class="collapse-item" href="{{url("activities")}}">All Activities</a>
                    </div>
                </div>
            </li>





            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefour"
                    aria-expanded="true" aria-controls="collapseFour">
                    <i class="fa fa-compass" style='color:white;'></i>
                    <span><strong style='color:white;'>vtu Transactons</strong></span>
                </a>
                <div id="collapsefour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{url('vtpassairtime')}}">Airtime</a>
                        <a class="collapse-item" href="{{url('vtpassdata')}}">Data</a>
                       <a class="collapse-item" href="{{url('vtpasscable')}}">Cable tv</a>
                        <a class="collapse-item" href="{{url("vtpasselectricity")}}">Electicity Bills</a>
                         
                        <a class="collapse-item" href="{{url("vtpasseducation")}}">Education</a>
                        <a class="collapse-item" href="{{url("vtpassbalance")}}">Vtpass Balance</a>
                    </div>
                </div>
            </li>

        
           <!--
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseten"
                    aria-expanded="true" aria-controls="collapseten">
                    <i class="fa fa-compass" style='color:white;'></i>
                    <span><strong style='color:white;'>OpenData</strong></span>
                </a>
                <div id="collapseten" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    
                        <a class="collapse-item" href="{{url('smartdata')}}">Sme Data</a>
                       
                        <a class="collapse-item" href="{{url("vtpasselectricity")}}">Electicity Bills</a>
                         
                       
                        <a class="collapse-item" href="{{url("smartbalance")}}">Open Data Balance</a>
                    </div>
                </div>
            </li>-->



           





          


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefive"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-money" style='color:white;'></i>
                    <span><strong style='color:white;'>Transactions</strong></span>
                </a>
                <div id="collapsefive" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{url('deposits')}}">Deposits</a>
                       
                       <a class="collapse-item" href="{{url('withdrawals')}}">Withdrawals</a>
                        <a class="collapse-item" href="{{url("transfers")}}">Transfers</a>
                         

                    </div>
                </div>
            </li>


             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsesix"
                    aria-expanded="true" aria-controls="collapsesix">
                    <i class="fa fa-cog" style='color:white;'></i>
                    <span><strong style='color:white;'>Settings</strong></span>
                </a>
                <div id="collapsesix" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{url('agreegatortransactionshares')}}">Agreegator Share(%)</a>
                        <a class="collapse-item" href="{{url('minimumbalance')}}">Minimum Wallet Balance</a>
                        <!--
                        <a class="collapse-item" href="{{url('educationcharges')}}">Education Charges</a>-->

                          <a class="collapse-item" href="{{url('flutterwaveaccesstoken')}}">Generate Flutterwave token</a>
                    </div>
                </div>
            </li>



 


             <li class="nav-item active">
                <a class="nav-link" href="{{url("commissions")}}">
                    <i class="fa fa-money"></i>
                    <span>vtu Transaction Commissions</span></a>
            </li>

            <!--

            <li class="nav-item active">
                <a class="nav-link" href="{{url("opendatapackages")}}">
                    <i class="fa fa-money"></i>
                    <span>SME Open Data Charges</span></a>
            </li>-->




          <!--
            <li class="nav-item active">
                <a class="nav-link" href="{{url("usersmessage")}}">
                    <i class="fa fa-envelope"></i>
                    <span>Send Message</span></a>
            </li>-->

             <li class="nav-item active">
                <a class="nav-link" href="{{url("updatesettings")}}">
                    <i class="fa fa-bell"></i>
                    <span>account</span></a>
            </li>


             <li class="nav-item active">
                <a class="nav-link" href="{{url("logout")}}">
                    <i class="fa fa-bullseye text-danger"></i>
                    <span class="text-danger">Logout</span></a>
            </li>







            




            











           



            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                   

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                               
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Dropifypay Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="{{asset("support.png")}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                               
                                <a class="dropdown-item" href="{{url("/updatesettings")}}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                        
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url("/logout")}}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">