<footer class="footer style7 modern-theme-bg" style="border-radius: 18px 18px 0 0; background: var(--main-gold, #bfa15a); color: var(--main-white, #fff); box-shadow: 0 4px 24px #bfa15a22;">
    <div class="container">
        <div class="container-wapper">
            <div class="row">
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-sm hidden-md hidden-lg">
                    <div class="stelina-newsletter style1">
                        <div class="newsletter-head">
                            <h3 class="title">{{__('Newsletter')}}</h3>
                        </div>
                        <div class="newsletter-form-wrap">
                            <div class="list">
                                {{--__('Sign up for our free video course and')}} <br/> {{__('urban garden inspiration')--}}
                            </div>
                            <input type="email" class="input-text email email-newsletter"
                                   placeholder="Your email letter">
                            <button class="button btn-submit submit-newsletter">{{__('SUBSCRIBE')}}</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="stelina-custommenu default">
                        <h2 class="widgettitle">{{__('links')}}</h2>
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="{{route('home.index')}}">{{__('Home')}}</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('products.list')}}?arrange_order=1">{{__('New Arrival')}}</a>
                            </li>
                           {{-- <li class="menu-item">
                                <h2 class="widgettitle">{{__('address')}}</h2> <span>{{$data['place']['address']}}</span>
                            </li>--}}
<li class="menu-item">
    <h2 class="widgettitle">{{ __('phone') }}</h2>
    <a href="https://wa.me/{{ $data['place']['phone'] }}" target="_blank">
        <img src="{{asset('website/assets/images/whatsapp-icon.png')}}" alt="Chat on WhatsApp" style="width: 24px; height: 24px; vertical-align: middle;">
        <span>{{-- $data['place']['phone'] --}}</span>
    </a>
</li>
                        </ul>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-xs">
                    <div class="stelina-newsletter style1">
                        <div class="newsletter-head">
                            <h3 class="title">{{__('Newsletter')}}</h3>
                        </div>
                        <div class="newsletter-form-wrap">
                           <!-- <div class="list">
                                Sign up for our free video course and <br/> urban garden inspiration
                            </div>-->
                            <input type="email" class="input-text email email-newsletter"
                                   placeholder="{{__('Your email letter')}}">
                            <button class="button btn-submit submit-newsletter">{{__('SUBSCRIBE')}}</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="stelina-custommenu default">
                        <h2 class="widgettitle">{{__('Information')}}</h2>
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="{{route('order.order-list')}}?current_order=1">{{__('Track Order')}}</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('order.order-list')}}?latest_order=1">{{__('Delivered Order')}}</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('about-us')}}">{{__('Contact Us')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-end">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="stelina-socials">
                            <ul class="socials">
                                <li>
                                    @foreach($data['business_setting'] as $setting)
                                       @if($setting['key']=='facebook')
                                            <a href="{{$setting['value']}}" class="social-item" target="_blank">
                                                <i class="icon fa fa-facebook"></i>
                                            </a>
                                       @endif
                                    @endforeach

                                </li>
                                <!--<li>
                                    <a href="#" class="social-item" target="_blank">
                                        <i class="icon fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="social-item" target="_blank">
                                        <i class="icon fa fa-instagram"></i>
                                    </a>
                                </li>-->
                            </ul>
                        </div>
                        <div class="coppyright">
                           {{__('Copyright ©')}}
                            <a href="{{route('home.index')}}">{{__('DUBIAWAY')}}</a>
                            {{__('. All rights reserved')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="footer-device-mobile">
    <div class="wapper">
        <div class="footer-device-mobile-item device-home">
            <a href="{{route('home.index')}}">
					<span class="icon">
						<i class="fa fa-home" aria-hidden="true"></i>
					</span>
                {{__('Home')}}
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-wishlist">
            <a href="{{route('products.list')}}?favourite=1">{{--route('get_user_fav')--}}
					<span class="icon">
						<i class="fa fa-heart" aria-hidden="true"></i>
					</span>
               {{__('Wishlist')}}
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-cart">
            <a href="@if(App\Modules\Core\Helper::getCartCount() > 0) {{ route('carts.list-cart') }} @else javascript:void(0); @endif">
					<span class="icon">
						<i class="fa fa-shopping-basket" aria-hidden="true"></i>
						<span class="count-icon">


							 {{ App\Modules\Core\Helper::getCartCount() }}

						</span>
					</span>
                <span class="text">{{__('Cart')}}</span>
            </a>
        </div>
        <div class="footer-device-mobile-item device-home device-user">
            <a href="{{route('auth.login')}}">
					<span class="icon">
						<i class="fa fa-user" aria-hidden="true"></i>
					</span>
                {{__('Account')}}
            </a>
        </div>
    </div>
</div>
<a href="#" class="backtotop">
    <i class="fa fa-angle-double-up"></i>
</a>