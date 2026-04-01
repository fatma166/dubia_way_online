
	@if(!empty($products))
    @foreach($products as $product)
	 @php
                            $price_after = $product['price']; // Initialize with the original price
                            if ($product['discount_type'] == "percent") {
                                $price_after -= ($product['price'] * $product['discount'] / 100);
	                           $discount_amount_computed=$product['discount'] / 100;
                            } else {
                                $price_after -= $product['discount'];
	                            $discount_amount_computed= $product['discount'];
                            }
	                       $precentage=ceil(($discount_amount_computed/$product['price'])*100);
                        @endphp
    <li class="product-item  col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-6 style-1">
        <div class="product-inner equal-element">
            <div class="product-top">
                <div class="flash">
											<span class="onnew">
												<span class="text">
										           {{$precentage}} %
												</span>
											</span>
                </div>
            </div>
            <div class="product-thumb">
                <div class="thumb-inner">
                    <a href="{{route('products.details',$product['id'])}}">
                        <img src="{{asset($product['image'])}}" alt="img" style="width:100%;height:250px;">
                    </a>
                    <div class="thumb-group">
                        <div class="yith-wcwl-add-to-wishlist">
                            <div class="yith-wcwl-add-button">
                                <a href="#">{{__('Add to Wishlist')}}</a>
                            </div>
                        </div>
                        <a href="{{route('products.details',$product['id'])}}" class="button quick-wiew-button">{{('Quick View')}}</a>
                        <div class="loop-form-add-to-cart">
                            <button class="single_add_to_cart_button button">{{__('Add to cart')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <h5 class="product-name product_title" style="height: 6rem !important;">
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

