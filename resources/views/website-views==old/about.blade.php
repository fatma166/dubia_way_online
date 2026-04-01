@extends('layouts.website.master')
@section('title')
    {{__("about")}}
@endsection

@section('content')
    <div class="main-content main-content-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{route('home.index')}}">{{__('Home')}}</a>
                            </li>
                            <li class="trail-item trail-end active">
                                {{__('About Us')}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="content-area content-about col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <h3 class="custom_blog_title">{{__('About Us')}}</h3>
                        <div class="page-main-content">
                            <div class="header-banner banner-image">
                                <div class="banner-wrap" style="background-image: url({{asset($place['cover_photo'])}}) !important;height:90rem">
                                    <div class="banner-header">
                                        <div class="col-lg-5 col-md-offset-7">
                                            <div class="content-inner">
                                                <h2 class="title">
                                                    {{__('New Collection')}} <br/> {{__('for you')}}
                                                </h2>
                                                <div class="sub-title">
                                                    {{__('Shop the latest products right')}} <br/>
                                                    {{__('We have beard supplies from top brands.')}}
                                                </div>
                                                <a href="{{route('products.list')}}" class="stelina-button button">{{__('Shop now')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-4">
                                    <div class="stelina-iconbox  layout1">
                                        <div class="iconbox-inner">
                                            <div class="icon-item">
                                                <span class="placeholder-text">01</span>
                                                <span class="icon flaticon-rocket-ship"></span>
                                            </div>
                                           <div class="content">
                                                <h4 class="title">
                                                   {{__('Free Delivery')}}
                                                </h4>
                                                <div class="text">
                                                    {{__('Free Delivery on all orders')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-lg-offset-1">
                                    <div class="stelina-iconbox  layout1">
                                        <div class="iconbox-inner">
                                            <div class="icon-item">
                                                <span class="placeholder-text">02</span>
                                                <span class="icon flaticon-return"></span>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">
                                                   {{__('contact_us')}}
                                                </h4>
                                                <div class="text">
                                                        <a href="https://wa.me/{{ $place['phone'] }}" target="_blank" style="margin-right:5rem">
        <img src="{{asset('website/assets/images/whatsapp-icon.png')}}" alt="Chat on WhatsApp" style="width: 24px; height: 24px; vertical-align: middle;">
        <span>{{-- $data['place']['phone'] --}}</span>
    </a>
                                            <a href="https://www.facebook.com/share/1BYhfXgjBB" class="social-item" target="_blank" style="
 
    padding: 1rem;
    border-radius: 999px;
">
                                                <i class="icon fa fa-facebook"></i>
                                            </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-lg-offset-1">
                                    <div class="stelina-iconbox  layout1">
                                        <div class="iconbox-inner">
                                            <div class="icon-item">
                                                <span class="placeholder-text">03</span>
                                                <span class="icon flaticon-padlock"></span>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">
                                                    {{__('opening_time')}}
                                                </h4>
                                                <div class="text">
                                                  {{__('24 Hours Opening')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                           <div class="team-member">
                               <div class="row">
                                   <div class="col-sm-12 border-custom">
                                       <span></span>
                                   </div>
                               </div>
                               <h2 class="custom_blog_title center">
                                   stelina’s Important Persons
                               </h2>
                               <div class="team-member-slider nav-center owl-slick"
                                    data-slick='{"autoplay":false, "autoplaySpeed":1000, "arrows":true, "dots":false, "infinite":true, "speed":800, "rows":1}'
                                    data-responsive='[{"breakpoint":"0","settings":{"slidesToShow":1}},{"breakpoint":"480","settings":{"slidesToShow":1}},{"breakpoint":"767","settings":{"slidesToShow":2}},{"breakpoint":"991","settings":{"slidesToShow":3}},{"breakpoint":"1199","settings":{"slidesToShow":3}},{"breakpoint":"2000","settings":{"slidesToShow":3}}]'>
                                   <div class="stelina-team-member">
                                       <div class="team-member-item">
                                           <div class="member_avatar">
                                               <img src="assets/images/member3.png" alt="img">
                                           </div>
                                           <h5 class="member_name">Mr Claudio</h5>
                                           <div class="member_position">
                                               CEO & Founder stelina Outfit
                                           </div>
                                       </div>
                                   </div>
                                   <div class="stelina-team-member">
                                       <div class="team-member-item">
                                           <div class="member_avatar">
                                               <img src="assets/images/member2.png" alt="img">
                                           </div>
                                           <h5 class="member_name">Mr Claudio</h5>
                                           <div class="member_position">
                                               CEO & Founder stelina Outfit
                                           </div>
                                       </div>
                                   </div>
                                   <div class="stelina-team-member">
                                       <div class="team-member-item">
                                           <div class="member_avatar">
                                               <img src="assets/images/member1.png" alt="img">
                                           </div>
                                           <h5 class="member_name">Mr Claudio</h5>
                                           <div class="member_position">
                                               CEO & Founder stelina Outfit
                                           </div>
                                       </div>
                                   </div>
                                   <div class="stelina-team-member">
                                       <div class="team-member-item">
                                           <div class="member_avatar">
                                               <img src="assets/images/member3.png" alt="img">
                                           </div>
                                           <h5 class="member_name">Mr Claudio</h5>
                                           <div class="member_position">
                                               CEO & Founder stelina Outfit
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection