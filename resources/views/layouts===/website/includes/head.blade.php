<head>
    <meta  charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ __("DUABI WAY") }} - @yield("title")</title>

    <meta name="description" content="@yield('meta_description', 'دبي واي (Dubai Way) - الوجهة الأولى للبرفانات والعطور في المنوفية ومصر. نقدم أكبر تشكيلة من العطور الرجالي والحريمي، الشرقي والغربي، بأسعار تنافسية. عطور أصلية، ماستر بوكس، وتركيب بجودة عالية. وكيل شركة فلافيا. توصيل سريع لكل المحافظات.')">
    <meta name="keywords" content="@yield('meta_keywords', 'برفانات المنوفية, عطور المنوفية, دبي واي, Dubai Way, عطور مصر, شراء عطور اونلاين, عطور رجالي, عطور حريمي, عطور شرقية, عطور فرنسية, عطور أصلية, عطور تركيب, مسك, عود, Flavia perfumes, perfumes Egypt, Menoufia perfumes, أفضل محل عطور')">
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/bootstrap.min.css') }}">
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


<!----------- new----->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P3PS2PL9');</script>
<!-- End Google Tag Manager -->

<!-- Schema.org Structured Data for Local SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Store",
  "name": "Dubai Way - دبي واي",
  "image": "{{ asset('website/assets/images/DubaiWay.jpeg') }}",
  "@id": "{{ route('home.index') }}",
  "url": "{{ route('home.index') }}",
  "telephone": "{{ $data['place']['phone'] ?? '' }}",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "{{ $data['place']['address'] ?? 'المنوفية' }}",
    "addressLocality": "Menoufia",
    "addressRegion": "Menoufia",
    "addressCountry": "EG"
  },
  "priceRange": "$$",
  "description": "أفضل متجر عطور في المنوفية ومصر. بيع عطور أصلية وتركيب.",
  "areaServed": ["Menoufia", "Egypt"]
}
</script>


</head>