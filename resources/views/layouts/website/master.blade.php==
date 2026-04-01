<!DOCTYPE html dir="rtl">
<?php $locale = app()->getLocale();?>

<html lang="{{ app()->getLocale() }}"  @if($locale=='ar')dir="rtl" @else dir="ltr"@endif>

@include('layouts.website.includes.head')

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
@include('layouts.website.includes.scripts')
@yield('script')
@stack('script')



</body>
</html>