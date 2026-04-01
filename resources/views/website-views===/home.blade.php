@extends('layouts.website.master')
@section('title')
    {{__("الرئيسية - أفضل عطور وبرفانات في المنوفية ومصر")}}
@endsection

@section('content')
<style>
<!-- تم نقل التنسيقات إلى modern-theme.css لتوحيد التصميم -->

@media (max-width: 768px) { /* Adjust for mobile screens */
    .slider-inner {
      //  height: 300px !important; /* Set a specific height for mobile */
    }

    .title-big {
        font-size: 16px !important; /* Adjust font size for mobile */
    }

    .button.btn-shop-the-look {
        padding: 10px !important; /* Adjust padding */
    }
}


.slider-inner {
    background-size: cover !important; /* Cover the entire area */
    background-position: center !important; /* Center the image */
    width: 100% !important; /* Full width */
    height: auto !important; /* Maintain aspect ratio */
    min-height: 300px !important; /* Optional: Set a minimum height */
}

@media (max-width: 768px) {
    .slider-inner {
        min-height: 200px !important; /* Adjust for smaller screens */
    }
}


@media (max-width: 575.98px) {
    .hide-on-mobile {
        display: none !important;
    }
}


.tabs-inline {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    padding: 0;
    margin: 0;
    list-style: none;
    gap: 0.5rem;
}

.tabs-inline li {
    flex: 1 1 auto;
    text-align: center;
}

.tabs-inline li a {
    display: block;
    padding: 10px 5px;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    background-color: #f9f9f9;
    color: #333;
}

.tabs-inline li.active a {
    background-color: #f39c12;
    color: white;
    font-weight: bold;
}
@media (max-width: 767px) {
    .stelina-tabs .tab-link li a {
        margin: 0 5px !important;
    }
}

.mobile-only {
    display: none;
}

@media (max-width: 575.98px) {
    .mobile-only {
        display: block !important;
    }
}

@media (max-width: 575.98px) {
    .mobile-img {
        height: 170px !important;
        object-fit: cover; /* Optional: crop if necessary */
    }
}

/* --- تحسينات التصميم الجديدة (Catchy Design) --- */
.feature-box {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #f0f0f0;
}
.feature-list {
    padding: 0;
    margin: 0;
    list-style: none;
}
.feature-list li {
    font-size: 16px;
    margin-bottom: 12px;
    padding: 12px;
    background: #f9f9f9;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    color: #333;
}
.feature-list li:before {
    content: '✔';
    color: #d78b07;
    margin-left: 10px;
    font-weight: bold;
    font-size: 18px;
}
.item-banner {
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.below_slider.inner {
    transition: transform 0.5s ease;
}
.item-banner:hover .below_slider.inner {
    transform: scale(1.05);
}
.btn-catchy {
    border-radius: 50px !important;
    box-shadow: 0 5px 15px rgba(215, 139, 7, 0.4) !important;
    transition: all 0.3s ease !important;
    border: none !important;
}
.btn-catchy:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(215, 139, 7, 0.6) !important;
}

</style>
    <div class="fullwidth-template">
<div class="home-slider style1 rows-space-30">
    <div class="container" dir="ltr">
        <div class="slider-owl owl-slick equal-container nav-center" dir="ltr"
             data-slick='{"autoplay":true, "autoplaySpeed":9000, "arrows":true, "dots":false, "infinite":true, "speed":1000, "rows":1}'
             data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":1}}]'>

            <?php
            $agent = new \Jenssegers\Agent\Agent(); // Use fully qualified class name
            $sliders =$agent->isMobile() ? $data['sliders_mobile'] : $data['sliders']; //$data['sliders']; //
            foreach ($sliders as $index => $value):
            ?>

                <div class="slider-item style{{$index+1}}">
                    <div style="/*background-image: url('{{ asset($value['image']) }}') !important;" class="slider-inner equal-element">
                     <a href="{{route('products.list')}}?offer_text">
                    <img src="{{ asset($value['image']) }}"/>
                    </a>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>

        <div class="banner-wrapp rows-space-35">
            <div class="container">
                <div class="row">
  <div class="mobile-only feature-box"><!--margin-top: .5rem !important;-->
    <h1 style="color: #d78b07; font-weight: bold; text-align: center; margin-bottom: 15px;">
        ✨ {{ __('خليك فاكر') }} ✨
    </h1>

    <ul class="feature-list" style="direction: rtl; text-align: right;">
        <li>شحن مجاني لأي طلب</li>
        <li>الدفع عند الاستلام</li>
        <li>معاينة المنتج مع المندوب</li>
        <li>استبدال او استرجاع خلال 3 أيام</li>
    </ul>
</div>




                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 below_slider_col hide-on-mobile">
                        <div class="banner">
                            <div class="item-banner style12">
                            <a href="{{route('products.list')}}?high_orders=1">
                                <div class="below_slider inner" style="background-image:  url({{asset('images/banner/1746753237.jpeg')}}) !important;
                                 height:250px;">
                                    <div class="banner-content">
                                        <h3 class="title">{{--__('Best Seller')--}}</h3>
                                        <div class="description">
                                            {{--__('Check out our your')--}} <br/> {{--__('perfume collection now!')--}}
                                        </div>

                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 below_slider_col hide-on-mobile">
                        <div class="banner">
                            <div class="item-banner style14">
                            <a href="{{route('products.list')}}?offer_text">
                                <div class="below_slider inner" style="background-image: url({{asset('images/banner/1746753291.jpeg')}}) !important;
                                height:250px; ">
                                    <div class="banner-content">
                                        @if(empty($coupon))
                                            <h4 class="stelina-subtitle">{{--__('no coupons available ...')--}}</h4>
                                            <h3 class="title">{{--__('follow our discounts')--}}</h3>
                                        @else
                                            <h4 class="stelina-subtitle">{{--$coupon['title']--}}</h4>
                                            <h3 class="title">{{--__('Big Sale')--}}<br/>
                                        </h3>
                                            <div class="code">
                                               {{--__('Use promo Code:')--}}
                                                <span class="nummer-code">{{--$coupon['code']--}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 below_slider_col hide-on-mobile">
                        <div class="banner">
                            <div class="item-banner style12 type2">
                             <a href="{{route('products.list')}}">
                                <div class="below_slider inner" style="background-image: url({{asset('images/banner/1746754194.jpeg')}});
                                height:250px; ">
                                    <div class="banner-content">
                                        <h3 class="title">{{--__('Lookbook')--}}</h3>
                                        <div class="description">
                                             <br/>
                                        </div>

                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="stelina-tabs  default rows-space-40">
            <div class="container">
              <div class="tab-head">
                    <ul class="tab-link">
                        <li class="active">
                            <a data-toggle="tab" aria-expanded="true" href="#bestseller">{{__('Bestseller')}}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" aria-expanded="true" href="#new_arrivals" class="new-arrivals-tab">{{__('New Arrivals')}} </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" aria-expanded="true" href="#top-rated" class="new-rate-tab">{{__('Top Rated')}}</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-container">
                    <div id="bestseller" class="tab-panel active">
                       {{-- @include('website-views\home_partails\bestseller')--}}
                    </div>
                    <div id="new_arrivals" class="tab-panel">

                    </div>
                    <div id="top-rated" class="tab-panel">

                    </div>
                <div style="text-align: center;">
    <a href="{{ route('products.list') }}">
        <button class="button btn-cart-to-checkout btn-catchy" id="checkout" style="background: #d78b07 !important; font-size: x-large; padding: 1.5rem 3rem;">
            {{ __('Show More') }}
        </button>
    </a>
</div>


                </div>
            </div>
        </div>
        <div class="banner-wrapp rows-space-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="banner">
                            <div class="item-banner style6">
                                @if(isset($banners_offers[0]))
                                 <img src="@if(isset($banners_offers[0])) {{asset($banners_offers[0]['image'])}} @endif" />
                                <!--<div class="inner">

                                    <div class="container">
                                        <div class="banner-content">
                                            <h4 class="stelina-subtitle">{!! $banners_offers[0]['title'] !!}</h4>

                                            <a href="{{route('products.list')}}" class="button btn-view-promotion">{{__('Shop now')}}</a>
                                        </div>
                                    </div>
                                </div>-->
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-in-stock-wrapp">

        </div>

    </div>

<style>
/* Mobile styles */
@media (max-width: 600px) {
    .banner-wrapp .row .banner .img {
        height: 20rem !important; /* Adjust height for mobile */
    }
}

@media (max-width: 600px) {
    .below_slider.inner {

        height: 173px !important;
    background-size: 69%;
    }
}

@media (max-width: 600px) {
    .row .below_slider_col {
       margin-bottom: 10px !important; /* Set height for mobile */
    }

}

/*.slider-inner {
    width: 100%!important;
    height: 500px !important; /* Set height to 500px */
   /* background-size: cover !important; /* Cover the entire div */
   /* background-position: center !important; /* Center the image */
/*}*/
</style>
@endsection
@section('script')
<script src="{{asset('website/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('website/assets/js/slick.js')}}"></script>
@endsection
@push('script')
    <script>
    $(document).ready(function() {

    $.ajax({
    url: '{{route('products.popular-products')}}', // Adjust the URL to your API endpoint
    method: 'GET',
    data:{"postion":"home_best"},
   // dataType: 'json',
    success: function(data) {
    // Clear the container
    $('#bestseller').empty();

    $('#bestseller').append(data);
    }
    });
       /* $.ajax({
            url: '{{route('products.list')}}', // Adjust the URL to your API endpoint
            method: 'GET',
            data:{"favourite":1},
            // dataType: 'json',
            success: function(data) {
                // Clear the container
                $('.product-in-stock-wrapp').empty();

                $('.product-in-stock-wrapp').append(data);
            }
        });*/
    });

    // Event handler for the new arrivals tab
    $('.new-arrivals-tab').on('click', function(event) {
        $.ajax({
            url: '{{route('products.latest-products')}}', // Adjust the URL to your API endpoint
            method: 'GET',
            data:{"postion":"latest"},
            // dataType: 'json',
            success: function(data) {
                // Clear the container
                $('#new_arrivals').empty();

                $('#new_arrivals').append(data);
            }
        });
    });




    $('.new-rate-tab').on('click', function(event) {
        $.ajax({
            url: '{{route('products.list')}}', // Adjust the URL to your API endpoint
            method: 'GET',
            data:{"high_rate":1},
            // dataType: 'json',
            success: function(data) {
                // Clear the container
                $('#top-rated').empty();

                $('#top-rated').append(data);
            }
        });
    });
    $('.slider-owl').slick({
        autoplay: true,
        autoplaySpeed: 9000,
        arrows: true,
        dots: false,
        infinite: true,
        speed: 1000,
        rows: 1,
        responsive: [
            {
                breakpoint: 2000,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    </script>
@endpush