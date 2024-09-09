<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/hyper_2/saas/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 13:44:15 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Log In | Dropify POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="{{asset("assets/js/hyper-config.js")}}"></script>

    <!-- App css -->
    <link href="{{asset("assets/css/app-saas.min.css")}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{asset("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg position-relative">
    <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
        <svg xmlns='http://www.w3.org/2000/svg' width='100%' height='100%' viewBox='0 0 800 800'>
            <g fill-opacity='0.22'>
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.1);" cx='400' cy='400' r='600' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.2);" cx='400' cy='400' r='500' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.3);" cx='400' cy='400' r='300' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.4);" cx='400' cy='400' r='200' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.5);" cx='400' cy='400' r='100' />
            </g>
        </svg>
    </div>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="{{url("/")}}">
                                <span><img src="{{asset("logo.jpg")}}" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                                <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                                @if(Session::get("error"))
                                  <div class="alert alert-danger">
                                    <strong class="text-danger">{{Session::get("error")}}</strong>
                                  </div>
                                @endif
                            </div>

                            <form action="{{route("admin.login")}}" method="post">
                                 @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" name='email' type="email" id="emailaddress" required="" placeholder="Enter your email">
                                </div>

                                <div class="mb-3">
                                  
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password"name="password"  id="password" class="form-control" placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" name="admin_login_btn" type="submit"> Log In </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->


                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        
        <script>document.write(new Date().getFullYear())</script> © Dropifypos
    </footer>
    <!-- Vendor js -->
    <script src="{{asset("assets/js/vendor.min.js")}}"></script>

    <!-- App js -->
    <script src="{{asset("assets/js/app.min.js")}}"></script>

</body>


<!-- Mirrored from coderthemes.com/hyper_2/saas/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jun 2024 13:44:15 GMT -->
</html>