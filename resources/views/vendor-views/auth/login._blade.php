<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8"/>
    <title>{{__("dashboard")}} - {{__("login")}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ isset($settings) ? $settings->{"icon_url"} : asset('images/favicon.ico')}}">

    <!-- App css -->
    @if(app()->getLocale() == "ar")
        <link href="{{asset('css/config/default/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css"
              id="bs-default-stylesheet"/>
        <link href="{{asset('css/config/default/app-rtl.min.css')}}" rel="stylesheet" type="text/css"
              id="app-default-stylesheet"/>

        <link href="{{asset('css/config/default/bootstrap-dark-rtl.min.css')}}" rel="stylesheet" type="text/css"
              id="bs-dark-stylesheet"/>
        <link href="{{asset('css/config/default/app-dark-rtl.min.css')}}" rel="stylesheet" type="text/css"
              id="app-dark-stylesheet"/>
        <link href="{{asset('css/dawam.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet"/>
        <!-- icons -->
        <link href="{{asset('css/icons-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{asset('css/config/default/bootstrap.min.css')}}" rel="stylesheet" type="text/css"
              id="bs-default-stylesheet"/>
        <link href="{{asset('css/config/default/app.min.css')}}" rel="stylesheet" type="text/css"
              id="app-default-stylesheet"/>

        <link href="{{asset('css/config/default/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css"
              id="bs-dark-stylesheet"/>
        <link href="{{asset('css/config/default/app-dark.min.css')}}" rel="stylesheet" type="text/css"
              id="app-dark-stylesheet"/>
        {{--        <link href="{{asset('css/dawam.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet"/>--}}
    <!-- icons -->
        <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    @endif

</head>

<body class="loading auth-fluid-pages pb-0"
      data-layout='{"mode": "{{$color_scheme_mode}}", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "{{$color_scheme_mode}}", "size": "default", "showuser": false}, "topbar": {"color": "{{$color_scheme_mode == 'dark' ? 'light' : 'dark'}}"}, "showRightSidebarOnPageLoad": true}'>

<div class="auth-fluid">
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">


                <!-- title-->
                <h4 class="mt-0">{{ __("login") }}</h4>
                <p class="text-muted mb-4">{{ __("Enter your email address and password to access admin panel") }}</p>

                @error("error")
                <p class="text-danger text-danger">{{ $message }}</p>
                @endError

                <form action="{{route('admin.auth.postLogin') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            {{__("email")}}
                            <span class="text-danger">*</span>
                        </label>
                        <input class="form-control @error("email") is-invalid @endError"
                               name="email" id="email" value="{{ old("email") }}"
                               placeholder="{{__("email")}}">
                        @error("email")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            {{__("password")}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" name="password" value="{{ old("password") }}"
                                   class="form-control @error("password") is-invalid @endError"
                                   placeholder="{{__("password")}}">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        @error("password")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="text-center d-grid">
                        <button class="btn btn-danger" type="submit">{{ __("login") }}</button>
                    </div>
                </form>
                <div class="text-center">
                    <h5 class="mt-3 text-muted">{{ __("Sign in with") }}</h5>
                 {{--  <ul class="social-list list-inline mt-3 mb-0">
                        <li class="list-inline-item">
                            <a href="{{ route("auth.facebook") }}" class="social-list-item border-primary text-primary">
                                <i class="mdi mdi-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route("auth.google") }}" class="social-list-item border-danger text-danger">
                                <i class="mdi mdi-google"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route("auth.twitter") }}" class="social-list-item border-info text-info">
                                <i class="mdi mdi-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route("auth.github") }}" class="social-list-item border-secondary text-secondary">
                                <i class="mdi mdi-github"></i>
                            </a>
                        </li>
                    </ul>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <img src="{{ isset($settings) ? $settings->{"logo_" . $color_scheme_mode . "_url"} : asset("images/logo.png") }}" alt="" class="w-100 mb-3"
                 style="max-height: 60px; object-fit: contain">
            <p class="lead">
                <i class="mdi mdi-format-quote-open"></i>
                {{ isset($settings) ? $settings->content : ""}}
                <i class="mdi mdi-format-quote-close"></i>
            </p>
            <h5 class="text-white">
                {{ isset($settings) ? $settings->name : ""}}
            </h5>
        </div>
    </div>
</div>


<!-- Vendor js -->
<script src="{{asset('js/vendor.min.js')}}"></script>

<!-- App js -->
<script src="{{asset('js/app.min.js')}}"></script>

</body>
</html>
