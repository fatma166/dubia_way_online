@if(!$request->ajax())
<ul class="row list-products auto-clear equal-container product-list">
    @endif
    @if ($list->isEmpty())
        <li class="product-item style-list col-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-ts-12">
            <div class="widgettitle">
                {{__('no order found')}}
            </div>
        </li>

    @else
        @foreach($list as $list_item)
            <li class="product-item style-list col-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-ts-12">
                <div class="product-inner equal-element">
                    <div class="product-top">
                        <div class="flash">
											<span class="onnew">
												<span class="text">
                                                  {{$list_item['order_status']}}
												</span>
											</span>
                        </div>
                    </div>
                    <div class="products-bottom-content">
                        <div class="product-thumb">
                            <div class="thumb-inner">
                                <a href="{{ route('order.details', ['id' =>$list_item['id']]) }}">
                                    <img src="{{asset('website/assets/images/DubaiWay.png')}}" alt="img">
                                </a>
                                <a href="{{ route('order.details', ['id' =>$list_item['id']]) }}" class="button quick-wiew-button">{{__('order details')}}</a>
                            </div>
                        </div>
                        <div class="product-info-left">
                            <div class="yith-wcwl-add-to-wishlist">
                                <div class="yith-wcwl-add-button">
                                    <a href="#">{{__('Add to Wishlist')}}</a>
                                </div>
                            </div>
                            <h5 class="product-name product_title">
                                <a href="#">{{__('order at')}} {{$list_item['created_at']}}</a>
                            </h5>

                            <ul class="product-attributes">
                                <li>
                                    {{__('details_count')}}:
                                </li>
                                <li>
                                    <a href="#">{{$list_item['details_count']}}</a>
                                </li>

                            </ul>
                            <ul class="attributes-display">
                                <li class="swatch-color">
                                    {{__('coupon_discount_amount')}}:
                                </li>
                                <li class="swatch-color">
                                    <a href="#">{{$list_item['coupon_discount_amount']}}</a>
                                </li>
                            </ul>

                        </div>
                        <div class="product-info-right">
                            <div class="price">
                                {{$list_item['order_amount']}}{{config('app.currency')}}
                            </div>
                            <div class="product-list-message">
                                <i class="icon fa fa-truck" aria-hidden="true"></i>
                                {{__('payment_method')}}:{{__($list_item['payment_method'])}}
                            </div>
                            <form class="cart">
                                <div class="single_variation_wrap">

                                    <button class="single_add_to_cart_button button">{{__($list_item['order_status'])}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    @endif
        {!! $list->withQueryString()->links('layouts.website.pagination.custom') !!}
    @if(!$request->ajax())
</ul>
    @endif
