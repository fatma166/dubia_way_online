
<header class="header style7 modern-theme-bg">
    <style>
    /* تحديث ألوان الهيدر والقوائم لتتناسق مع اللوجو والتصميم الحديث */
    .header-nav-container, .header-nav-wapper, .header-nav, .main-menu-wapper, .vertical-wapper.block-nav-categori, .stelina-nav-vertical.vertical-menu, .main-menu {
        background: var(--main-gold, #bfa15a);
        box-shadow: 0 2px 12px #bfa15a22;
    }
    .header-nav .main-menu > li > a,
    .stelina-nav-vertical.vertical-menu > li > a,
    .main-menu > li > a {
        color: var(--main-white, #fff) !important;
        font-weight: bold;
        font-size: 1.08rem;
        letter-spacing: 0.5px;
        border-radius: 12px;
        margin: 0 6px;
        padding: 8px 18px;
        transition: background 0.2s, color 0.2s;
        position: relative;
        z-index: 2;
    }
    .header-nav .main-menu > li > a:hover,
    .stelina-nav-vertical.vertical-menu > li > a:hover,
    .main-menu > li > a:hover {
        background: var(--main-black, #232323) !important;
        color: var(--main-gold, #bfa15a) !important;
    }
    .vertical-wapper.block-nav-categori .block-title, .vertical-wapper.block-nav-categori .text {
        color: #fff;
        font-weight: bold;
    }
    .header-nav .main-menu > li.active > a,
    .main-menu > li.active > a {
        background: var(--main-black, #232323) !important;
        color: var(--main-gold, #bfa15a) !important;
    }
    .header.style7 .top-bar {
        background: var(--main-gold, #bfa15a);
        color: var(--main-white, #fff);
    }
    .header.style7 .header-message {
        color: var(--main-white, #fff);
    }
    .header-language .stelina-language .language-toggle {
        color: var(--main-white, #fff);
    }
    .header-language .stelina-submenu {
        background: var(--main-black, #232323);
        color: var(--main-white, #fff);
    }
    .header-language .stelina-submenu > li > a {
        color: var(--main-white, #fff);
    }
    .header-language .stelina-submenu > li > a:hover {
        background: #191919;
        color: var(--main-gold, #bfa15a);
    }
    /* إصلاح مشكلة تغطية العناصر التفاعلية */
    .header-nav-container, .header-nav-wapper, .header-nav, .main-menu-wapper, .vertical-wapper.block-nav-categori, .stelina-nav-vertical.vertical-menu, .main-menu {
        pointer-events: auto !important;
    }
    .main-menu > li, .stelina-nav-vertical.vertical-menu > li {
            /* إضافة فئة logo حول صورة اللوجو لتسهيل التحكم في مظهرها */
            .logo img {
                max-height: 60px;
                border-radius: 16px;
                background: var(--main-white, #fff);
                padding: 6px 16px;
                box-shadow: 0 2px 8px #bfa15a33;
            }
        pointer-events: auto !important;
    }
    .main-menu > li > a, .stelina-nav-vertical.vertical-menu > li > a {
        pointer-events: auto !important;
    }
    /* لا نستخدم أي طبقة تغطي العناصر أو position: absolute على الخلفية */
    </style>
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <div class="header-message">
                   {{__('Welcome to our online store!')}}
                </div>
            </div>
            <div class="top-bar-right">


                <div class="header-language">
    <div class="stelina-language stelina-dropdown">
        <a href="#" class="active language-toggle" data-stelina="stelina-dropdown">
            <span>
                {{ session('locale', 'en') === 'ar' ? __('Arabic') : __('English') }}
            </span>
        </a>
        <ul class="stelina-submenu" style="display: none;">
            <li class="switcher-option">
                <a href="{{ route('set.locale', ['locale' => 'en']) }}">
                    <span>{{ __('English') }}</span>
                </a>
            </li>
            <li class="switcher-option">
                <a href="{{ route('set.locale', ['locale' => 'ar']) }}">
                    <span>{{ __('Arabic') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>


                <ul class="header-user-links">
                @if(Auth::check())
                    <!-- User is logged in -->
                        <li>
                            {{__('Welcome')}}, {{ Auth::user()->f_name }} <!-- Display the user's name -->
                            <span class="" style="margin-left: 8px; color: red;"> <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-right: whitesmoke 1px solid;padding: 2rem; margin-right: 10px;margin-left: -14px;">
                                {{ __('Logout') }}
                            </a></span>
                        </li>

                @else
                    <!-- User is not logged in -->
                        <li style="float: left">
                            <a href="{{ route('auth.login') }}" >{{ __('Login') }}</a> -
                            <a href="{{ route('auth.show-register') }}" >{{ __('Register') }}</a>
                        </li>
                        <li style="position: absolute; float: right;"></li>
                    @endif


                </ul>
            </div>
        </div>

    </div>
    <div>@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif</div>
    <div class="container">
        <div class="main-header">
            <div class="row">
                <div class="col-lg-3 col-sm-4 col-md-3 col-xs-7 col-ts-12 header-element">
                    <div class="logo">
                        <a href="{{route('home.index')}}">
                            <img src="{{asset('website/assets/images/DubaiWay.png')}}" alt="Dubai Way" style="width: 210px;padding-top: -15px;margin-top: -57px;">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-sm-8 col-md-6 col-xs-5 col-ts-12">
                    <div class="block-search-block">
                        <form class="form-search form-search-width-category" method="get" action="{{route('products.list')}}" >
                            <div class="form-content">
                                <div class="category">
                                    <select  name="category_id" title="cate" data-placeholder="{{__('All Categories')}}" class="chosen-select"
                                            tabindex="1" style="padding:7px 26px !important; ">
										 <option value="">{{__('All')}}</option>
                                        @foreach($categories as $key=>$category)
                                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="inner">
                                    <input type="text" class="input" name="search" value="" placeholder="{{__('Search here')}}">
                                </div>
                                <button class="btn-search" type="submit">
                                    <span class="icon-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-12 col-md-3 col-xs-12 col-ts-12">
                    <div class="header-control">
                        <div class="block-minicart stelina-mini-cart block-header stelina-dropdown">
                            <a href="@if(App\Modules\Core\Helper::getCartCount() > 0) {{ route('carts.list-cart') }} @else javascript:void(0); @endif" class="shopcart-icon" @if(App\Modules\Core\Helper::getCartCount() == 0) data-stelina="stelina-dropdown" @endif>
                                Cart
                                <span class="count" id="cart-count">
            {{ App\Modules\Core\Helper::getCartCount() }}
        </span>
                            </a>
                            @if(App\Modules\Core\Helper::getCartCount() ==0)
                                 <div class="no-product stelina-submenu">
                                <p class="text">
                                    {{ __('You have') }}
                                    <span id="item-count">
                {{ App\Modules\Core\Helper::getCartCount() }} {{ __('item(s)') }}
            </span>
                                    {{__('in your bag')}}
                                </p>
                            </div>
                            @endif
                        </div>
                        <div class="block-account block-header stelina-dropdown">
                            <a href="{{ route('auth.login') }}">
                                <span class="flaticon-user"></span>
                            </a>
                        </div>
                        <a class="menu-bar mobile-navigation menu-toggle" href="#">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav-container">
        <div class="container">
            <div class="header-nav-wapper main-menu-wapper">
                <div class="vertical-wapper block-nav-categori">
                    <div class="block-title">
						<span class="icon-bar">
							<span></span>
							<span></span>
							<span></span>
						</span>
                        <span class="text">{{__('All Categories')}}</span>
                    </div>
                    <div class="block-content verticalmenu-content">
                        <ul class="stelina-nav-vertical vertical-menu stelina-clone-mobile-menu">
                            @if(isset($categories) && $categories->count())
                                @foreach($categories as $category)
                                    <li class="menu-item">
                                        <a href="{{route('products.list')}}?category_id={{$category['id']}}" class="stelina-menu-item-title" title="{{ $category->name }}">{{ $category->name }}</a>

                                    </li> <!-- Adjust based on your category model -->
                                @endforeach
                            @else
                                <li>No categories available.</li>
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="header-nav">
                    <div class="container-wapper">
                        <ul class="stelina-clone-mobile-menu stelina-nav main-menu " id="menu-main-menu">
                            <li class="menu-item">
                                <a href="{{route('home.index')}}" class="stelina-menu-item-title" title="Home">{{__('Home')}}</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('products.list')}}" class="stelina-menu-item-title" title="Shop">{{__('products')}}</a>
                            </li>
                           <!-- <li class="menu-item  menu-item-has-children item-megamenu">
                                <a href="#" class="stelina-menu-item-title" title="Pages">Pages</a>
                                <span class="toggle-submenu"></span>
                                <div class="submenu mega-menu menu-page">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 menu-page-item">
                                            <div class="stelina-custommenu default">
                                                <h2 class="widgettitle">Shop Pages</h2>
                                                <ul class="menu">
                                                    <li class="menu-item">
                                                        <a href="shoppingcart.html">Shopping Cart</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="checkout.html">Checkout</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="contact.html">Contact us</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="404page.html">404</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="login.html">Login/Register</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 menu-page-item">
                                            <div class="stelina-custommenu default">
                                                <h2 class="widgettitle">Product</h2>
                                                <ul class="menu">
                                                    <li class="menu-item">
                                                        <a href="productdetails-fullwidth.html">Product Fullwidth</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="productdetails-leftsidebar.html">Product left
                                                            sidebar</a>
                                                    </li>
                                                    <li class="menu-item">
                                                        <a href="productdetails-rightsidebar.html">Product right
                                                            sidebar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 menu-page-item">
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 menu-page-item">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="menu-item  menu-item-has-children">
                                <a href="inblog_right-siderbar.html" class="stelina-menu-item-title"
                                   title="Blogs">Blogs</a>
                                <span class="toggle-submenu"></span>
                                <ul class="submenu">
                                    <li class="menu-item menu-item-has-children">
                                        <a href="#" class="stelina-menu-item-title" title="Blog Style">Blog Style</a>
                                        <span class="toggle-submenu"></span>
                                        <ul class="submenu">
                                            <li class="menu-item">
                                                <a href="bloggrid.html">Grid</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="bloglist.html">List</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="bloglist-leftsidebar.html">List Sidebar</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item menu-item-has-children">
                                        <a href="#" class="stelina-menu-item-title" title="Post Layout">Post Layout</a>
                                        <span class="toggle-submenu"></span>
                                        <ul class="submenu">
                                            <li class="menu-item">
                                                <a href="inblog_left-siderbar.html">Left Sidebar</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="inblog_right-siderbar.html">Right Sidebar</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>-->
                            <li class="menu-item">
                                <a href="{{route('about-us')}}" class="stelina-menu-item-title" title="About">{{__('About')}}</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('order.order-list')}}" class="stelina-menu-item-title" title="Shop">{{__('my orders')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="header-device-mobile">
    <div class="wapper">
        <div class="item mobile-logo">
            <div class="logo">
                <a href="#">
                    <img src="{{asset('website/assets/images/DubaiWay.png')}}" alt="Dubai Way" style="11rem !important">
                </a>
            </div>
        </div>
        <div class="item item mobile-search-box has-sub">
            <a href="#" style="border:none !important;">
						<span class="icon">
							<i class="fa fa-search" aria-hidden="true"></i>
						</span>
            </a>
            <div class="block-sub">
                <a href="#" class="close" style="border:none !important;">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                <div class="header-searchform-box">
                    <form class="header-searchform"  method="get" action="{{route('products.list')}}">
                        <div class="searchform-wrap">
                            <input type="text" name="search" class="search-input" placeholder="Enter keywords to search...">
                            <input type="submit" class="submit button" value="Search">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="item mobile-settings-box has-sub">
            <a href="#" style="border:none !important;">
						<span class="icon">
							<i class="fa fa-cog" aria-hidden="true"></i>
						</span>
            </a>
            <div class="block-sub">
                <a href="#" class="close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                <div class="block-sub-item">
                    <h5 class="block-item-title">{{config('app.currency')}}</h5>
                    <form class="currency-form stelina-language">
                        <ul class="stelina-language-wrap">
                            <li class="active">
                                <a href="{{ route('set.locale', ['locale' => 'en']) }}">
                                    <span>{{ __('English') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('set.locale', ['locale' => 'ar']) }}">
                                    <span>{{ __('Arabic') }}</span>
                                </a>

                            </li>

                        </ul>
                    </form>
                </div>
            </div>
        </div>
       <!-- <div class="item menu-bar">
            <a class=" mobile-navigation  menu-toggle" href="#">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>-->
 <div class="item menu-bar" style="position: relative;">
   <div class="menu-pointer">{{__('Press Here')}}👆</div>
    <a class="mobile-navigation menu-toggle" href="#"  style="border: none !important;padding: 3px 11px 10px;">
        <span></span>
        <span></span>
        <span></span>
    </a>
</div>

    </div>
</div>
<style>
.menu-pointer {
     font-family: system-ui, sans-serif;
    position: absolute;
    top: -50px;
    right: 0;
    background-color: #f39c12;
    color: white;
    padding: 5px 8px;
    border-radius: 5px;
    font-size: 12px;
    animation: bounce 1s infinite;
    z-index: 9999;
    white-space: nowrap;
    margin-top: 127px;
}

/* Animation */
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

/* Show only on mobile */
@media (min-width: 768px) {
    .menu-pointer {
        display: none;
    }
}

</style>

<script>
   /* document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {
            const pointer = document.querySelector('.menu-pointer');
            if (pointer) pointer.style.display = 'none';
        }, 5000);
    });*/
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const languageToggle = document.querySelector('.language-toggle');
    const submenu = document.querySelector('.stelina-submenu');

    languageToggle.addEventListener('click', function(event) {
        alert(submenu.style.display);
        event.preventDefault(); // Prevent the default anchor behavior
        if(submenu.style.display =="none") $('.stelina-submenu').css('display','block');
        //( submenu.style.display == 'block') ? 'none' : 'block'; // Toggle the display
    });

    // Close the dropdown if clicking outside
    document.addEventListener('click', function(event) {
        if (!languageToggle.contains(event.target) && !submenu.contains(event.target)) {
            submenu.style.display = 'none';
        }
    });
});
</script>


</script>