<style>
    .product-inner {
        transition: all 0.3s ease;
        border: 1px solid #f1f1f1;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        background: #fff;
    }
    .product-inner:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transform: translateY(-5px);
        border-color: #e0e0e0;
    }
    .product-name {
        margin-bottom: 2px !important;
    }
    .product-name a {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 75px;
        line-height: 1.5;
    }
    .stars-rating {
        margin-bottom: 5px;
    }
    .price ins {
        text-decoration: none;
        font-weight: bold;
        color: #d32f2f;
    }
</style>
	@if(!empty($products))
    @foreach($products as $product)
	 @php
                            $price_after = $product['price']; // Initialize with the original price
                            $percentage = 0;
                            if ($product['discount_type'] == "percent") {
                                $price_after -= ($product['price'] * $product['discount'] / 100);
                                $percentage = $product['discount'];
                            } else {
                                $price_after -= $product['discount'];
                                if($product['price'] > 0) $percentage = ($product['discount'] / $product['price']) * 100;
                            }
	                       $percentage=ceil($percentage);
                        @endphp
    <li class="product-item  col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-6 style-1">
        <div class="product-inner equal-element" onclick="window.location.href='{{route('products.details',$product['id'])}}'">
            <div class="product-top">
                <div class="flash">
											<span class="onnew">
												<span class="text">
										           {{$percentage}} %
												</span>
											</span>
                </div>
            </div>
            <div class="product-thumb">
                <div class="thumb-inner">
                    <a href="{{route('products.details',$product['id'])}}">
                        <img src="{{asset($product['image'])}}" alt="img" style="width:100%;height:250px;object-fit:cover;">
                    </a>
                    <div class="thumb-group" onclick="event.stopPropagation()">
                        <div class="yith-wcwl-add-to-wishlist">
                            <div class="yith-wcwl-add-button">
                                <a href="#">{{__('Add to Wishlist')}}</a>
                            </div>
                        </div>
                        <a href="{{route('products.details',$product['id'])}}" class="button quick-wiew-button">{{('Quick View')}}</a>
                        <div class="loop-form-add-to-cart">
                            <button class="single_add_to_cart_button button" data-product-id="{{$product['id']}}">{{__('Add to cart')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <h5 class="product-name product_title">
                    <a href="{{route('products.details',$product['id'])}}">{{$product['name']}}</a>
                </h5>
                <div class="group-info">
                    <div class="stars-rating">
                        <div class="star-rating">
                            <span class="star-5"></span>
                        </div>
                        <div class="count-star">
                            ({{$product['avg_rating']}})
                        </div>
                    </div>
                    <div class="price">
                        <del>
                            {{$product['price']." ".config('app.currency')}}
                        </del>
                       
                        <ins>
                            {{ $price_after . " " . config('app.currency') }}
                        </ins>
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endforeach
	@else
	{{__('no product found')}}
	@endif
