@extends('layouts.website.master')
@section('title')
    {{__("Orders")}}
@endsection

@section('content')
    <div class="main-content main-content-product no-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{route('home.index')}}">{{__('Home')}}</a>
                            </li>
                            <li class="trail-item trail-end active">
                                {{__('orders')}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="content-area  shop-grid-content full-width col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <div class="shop-top-control">
                            <form class="filter-choice select-form">
                                <span class="title">Sort by</span>
                                <select title="by" data-placeholder="Price: Low to High" class="chosen-select">
                                    <option value="1">{{__('Default sorting')}}</option>
                                    <option value="current_order">{{__('current_order')}}</option>
                                    <option value="latest_order">{{__('delivered_order')}}</option>
                                    <option value="canceled">{{__('canceled_order')}}</option>
                                </select>
                            </form>
                            <div class="grid-view-mode">
                                <div class="inner">
                                    <a href="{{route('products.list')}}" class="modes-mode mode-list active">
                                        <span></span>
                                        <span></span>
                                    </a>
                                    <a href="{{route('products.list')}}" class="modes-mode mode-grid">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <h3 class="custom_blog_title">
                            {{__('list orders')}}
                        </h3>

                        @include('website-views\orders\partails._table')
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>


        // Event handler for the new arrivals tab
        $('.chosen-select').on('change', function(event) {
            data=$(this).val();
            $.ajax({
                url: '{{route('order.order-list')}}', // Adjust the URL to your API endpoint
                method: 'GET',
                data:{data:1},
                // dataType: 'json',
                success: function(data) {
                    // Clear the container
                    $('.product-list').empty();

                    $('.product-list').append(data);
                }
            });
        });

    </script>
@endsection('script')