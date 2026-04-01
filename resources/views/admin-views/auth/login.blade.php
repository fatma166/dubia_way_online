<!DOCTYPE html>
<html lang="en" data-menu-color="brand">

    <head>
        <meta charset="utf-8" />
        <title>لوحة تحكم الادمن | {{__('DUBIAWAY')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

        <!-- google fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Theme Config Js -->
        <script src="{{asset('assets/js/head.js')}}"></script>

        <!-- Bootstrap css -->
        <link href="{{asset('assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

        <!-- App css -->
        <link href="{{asset('assets/css/app-rtl.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Icons css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <div class="auth-brand">
                                        <!-- <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="assets/images/logo-login.png" alt="" height="22">
                                            </span>
                                        </a>

                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="assets/images/logo-login.png" alt="" height="22">
                                            </span>
                                        </a> -->
                                    </div>
                                     <img style="width: 10rem;" src="{{asset('assets/images/logo-dark.png')}}" alt="logo" class="logo-lg"/>
                                    <h1 class="mb-3">تسجيل الدخول</h1>
                                </div>

                                @error("error")
                                <p class="text-danger text-danger">{{ $message }}</p>
                                @endError

                                <form action="{{route('admin.auth.postLogin') }}" method="post">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">البريد الإلكتروني</label>
                                        <input class="form-control" @error("email") is-invalid @endError"
                                        name="email" id="email" value="{{ old("email") }}"
                                        placeholder="ادخل البريد الالكتروني">
                                        @error("email")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">كلمة المرور</label>
                                        <div class="input-group input-group-merge">
                                            <input id="password" class="form-control" placeholder="ادخل كلمة المرور"  type="password" id="password" name="password" value="{{ old("password") }}"
                                             @error("password") is-invalid @endError">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                        @error("password")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                            <label class="form-check-label" for="checkbox-signin">تذكرني</label>
                                        </div>
                                    </div>

                                    <div class="text-center d-grid">
                                        <button type="submit"  class="btn btn-primary" type="submit"> تسجيل دخول </button>
                                    </div>

                                </form>



                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            <div><script>document.write(new Date().getFullYear())</script> © جميع الحقوق محفوظة إلي دبي واي</div>
        </footer>

        <!-- Authentication js -->
        <script src="{{asset('assets/js/pages/authentication.init.js')}}"></script>

    </body>
</html>
