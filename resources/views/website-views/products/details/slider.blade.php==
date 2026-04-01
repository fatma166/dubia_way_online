
    @foreach($products as $product)
    <div class="product-item style-1">
        <div class="product-inner equal-element">
            <div class="product-top">
                <div class="flash">
													<span class="onnew">
														<span class="text">
	           @if($product['favourite'] == 1)
                    <i class="fa fa-star filled" style="color:red;"></i>  <!-- Filled star icon -->
                @else
                    <i class="fa fa-star" style="color:white;"></i>  <!-- Empty star icon -->
                @endif
														</span>
													</span>
                </div>
            </div>
            <div class="product-thumb">
                <div class="thumb-inner">
                    <a href="{{route('products.details',$product['id'])}}">
                        <img src="{{asset($product['image'])}}" alt="img">
                    </a>
                   <!-- <div class="thumb-group">
                        <div class="yith-wcwl-add-to-wishlist">
                            <div class="yith-wcwl-add-button">
                                <a href="#">{{__('Add to Wishlist')}}</a>
                            </div>
                        </div>
                        <a href="#" class="button quick-wiew-button">{{__('Quick View')}}</a>
                        <div class="loop-form-add-to-cart">
                            <button class="single_add_to_cart_button button">{{__('Add to cart')}}
                            </button>
                        </div>
                    </div>-->
                </div>
            </div>
            <div class="product-info">
                <h5 class="product-name product_title">
                    <a href="{{route('products.details',$product['id'])}}">{{$product['name']}}</a>
                </h5>
                <div class="group-info">
                    <div class="stars-rating">
                        <div class="star-rating">
                            <span class="star-3"></span>
                        </div>
                        <div class="count-star">
                            ({{$product['avg_rating']}})
                        </div>
                    </div>
                    <div class="price">
                        <del>
                            {{$product['price']." ".config('app.currency')}}
                        </del>
                        @php
                            $price_after = $product['price']; // Initialize with the original price
                            if ($product['discount_type'] == "percent") {
                                $price_after -= ($product['price'] * $product['discount'] / 100);
                            } else {
                                $price_after -= $product['discount'];
                            }
                        @endphp
                        <ins>
                            {{ $price_after . " " . config('app.currency') }}
                        </ins>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

