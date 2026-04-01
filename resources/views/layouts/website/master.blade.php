<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

@include('layouts.website.includes.head')

<style>
    /* Responsive adjustments for Arabic (RTL) */
    html[dir="rtl"] body {
        text-align: right;
        direction: rtl;
    }
    /* Fix alignment for RTL */
    html[dir="rtl"] .text-left { text-align: right !important; }
    html[dir="rtl"] .text-right { text-align: left !important; }
    html[dir="rtl"] .float-left { float: right !important; }
    html[dir="rtl"] .float-right { float: left !important; }

    @media (max-width: 768px) {
        html[dir="rtl"] body { overflow-x: hidden; }
        html[dir="rtl"] .container {
            padding-right: 20px !important;
            padding-left: 20px !important;
        }

        /* Mobile Header Styling */
        .header-device-mobile, .header-mobile {
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 10px 15px !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #333;
        }
        .header-device-mobile .logo, .header-mobile .logo {
            text-align: center;
            flex-grow: 1;
        }
        .header-device-mobile .logo img, .header-mobile .logo img {
            max-height: 75px;
            width: auto;
            display: inline-block;
        }
    }
</style>

<body class="home modern-theme-bg">

<!---------google advs code -------->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P3PS2PL9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->





@include('layouts.website.includes.nav')
<div class="container">
    <div class="main-content">
        @yield('content')
    </div>
</div>
@include('layouts.website.includes.footer')
<script>
    var isRtl = {{ app()->getLocale() == 'ar' ? 'true' : 'false' }};
</script>
@include('layouts.website.includes.scripts')
@yield('script')
@stack('script')



</body>
</html>