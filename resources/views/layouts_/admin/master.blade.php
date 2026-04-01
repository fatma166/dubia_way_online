<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('layouts.admin.includes.head')



<body>
<!-- Begin page -->
<div id="wrapper">
    <!-- ========== Menu ========== -->
    <?php $segment=Request::segment(2); ?>
    @if(($segment != "login") && ($segment != "form_email"))
            @include('layouts.admin.includes.side_menu')
    @endif

<!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <?php $segment=Request::segment(2); ?>
        @if(($segment != "login") && ($segment != "form_email"))
              @include('layouts.admin.includes.nav')
            @endif

        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                @if ($message = Session::get('warning'))
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                @if ($message = Session::get('info'))
                    <div class="alert alert-info alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                       {{__('Please check the form below for errors')}}
                    </div>
            @endif

                    @yield('content')
                <!-- end page-->
            </div>
            <!-- End Content-->
        </div>

        <!-- Start Footer here -->
        @include('layouts.admin.includes.footer')
    <!-- End Footer -->
    </div>
</div>
@include('layouts.admin.includes.scripts')
@yield('script')
@stack('script')



@if(request()->filled("print"))
    <script>
        window.print();
        // self.focus();
        // window.onafterprint = function(){
        //     window.close();
        // }
    </script>
    <style>
        @media print {
            form, input, button, .btn, .hidden-print{
                display: none !important;
            }
        }
    </style>
@endif
</body>
</html>

