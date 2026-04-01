<head>
    <meta  charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ __("DUABI WAY") }} - @yield("title")</title>

    <meta name="description" content="@yield('meta_description', 'The largest company in Egypt specialising in Turkish Oriental perfumes (Masterbox, Outlet) ، 100% original fragrances of unrivalled quality. From soft floral notes to strong oriental scents
More than ten years of experience in ready-made perfumes.
Agent of the Emirati company Flavia in Egypt.
A very large assortment of western and eastern perfumes (more than 350 perfumes)')">
    <meta name="keywords" content="Dubai, Perfume, delivery, orginal,care,skin care,best">
    <link rel="canonical" href="{{ request()->url() }}">

    <meta name="author" content="DUABI WAY">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ __("DUABI WAY") }} - @yield("title")">
    <meta property="og:description" content="@yield('meta_description', 'Original Perfume')">
    <meta property="og:image" content="@yield('meta_image', asset('website/assets/images/DubaiWay.jpeg'))">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">

        <!-- Favicon -->
    <link rel="icon" href="{{ asset('website/assets/images/dabia_way.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('website/assets/images/dabia_way.ico') }}"/>

    <!-- Stylesheets -->
	<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/bootstrap.min.css') }}">
    <!--<link rel="apple-touch-icon" href="{{ asset('path/to/apple-touch-icon.png') }}">-->
<link rel="shortcut icon" type="image/x-icon" href="{{asset('website/assets/images/DubaiWay.jpeg')}}"/>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet">
<link rel="stylesheet" href="{{asset('website/assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/slick.css')}}">
<!-- Modern theme overrides -->
<link rel="stylesheet" href="{{ asset('assets/css/modern-theme.css') }}">
<link rel="stylesheet" href="{{asset('website/assets/css/chosen.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/pe-icon-7-stroke.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/magnific-popup.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/lightbox.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/js/fancybox/source/jquery.fancybox.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/jquery.scrollbar.min.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/css/mobile-menu.css')}}">
<link rel="stylesheet" href="{{asset('website/assets/fonts/flaticon/flaticon.css')}}">
<?php $locale = app()->getLocale();?>
@if($locale=='ar')
<link rel="stylesheet" href="{{asset('website/assets/css/style.css')}}">
@else
    <link rel="stylesheet" href="{{asset('website/assets/css/style_orginal.css')}}">

@endif
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <!-- Facebook Pixel Code -->
   <!--<script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '702711022303148');
        fbq('track', 'PageView');
    </script>


    <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "rzblnkqwug");
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=702711022303148&ev=PageView&noscript=1"
    /></noscript>-->



    <!----- new start--->
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '702711022303148');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=702711022303148&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<!----------- new----->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P3PS2PL9');</script>
<!-- End Google Tag Manager -->


<!-- TikTok Pixel Code Start -->
<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};


  ttq.load('D4U3AIRC77U2FI26UQR0');
  ttq.page();
}(window, document, 'ttq');
</script>
<!-- TikTok Pixel Code End -->



</head>