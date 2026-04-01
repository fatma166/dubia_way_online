<div class="container">
    <h3 class="custommenu-title-blog white">
       {{__('Featured Products')}}
    </h3>
    <div class="stelina-product style3">
        <ul class="row list-products auto-clear equal-container product-grid">
            @foreach($products as $product)
            <li class="product-item  col-lg-4 col-md-6 col-sm-6 col-xs-6 col-ts-12 style-3">
                <div class="product-inner equal-element">
                    <div class="product-thumb">
                        <div class="product-top">
                            <div class="flash">
												<span class="onnew">
													<span class="text">
														new
													</span>
												</span>
                            </div>
                            <div class="yith-wcwl-add-to-wishlist">
                                <div class="yith-wcwl-add-button" id="{{$product['id']}}" >
                                    <a href="#" tabindex="0" onclick="add_delete_fav(event, {{$product['id']}})">{{__('Add to Wishlist')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="thumb-inner">
                            <a href="#" tabindex="0">
                                <img src="{{asset($product['image'])}}" alt="img" style="width:300px;height:300px;">
                            </a>
                        </div>
                        <a href="{{route('products.details',$product['id'])}}" class="button quick-wiew-button" tabindex="0">{{__('Quick View')}}</a>
                    </div>
                    <div class="product-info">
                        <h5 class="product-name product_title" style="height: 6rem !important;">
                            <a href="#" tabindex="0">{{$product['name']}}</a>
                        </h5>
                        <div class="group-info">
                            <div class="stars-rating">
                                <div class="star-rating">
                                    <span class="star-3"></span>
                                </div>
                                <div class="count-star">
                                    ({{$product['rating_count']}})
                                </div>
                            </div>
                            <div class="price">
                                @php
                                    $price_after = $product['price']; // Initialize with the original price
                                    if ($product['discount_type'] == "percent") {
                                        $price_after -= ($product['price'] * $product['discount'] / 100);
                                    } else {
                                        $price_after -= $product['discount'];
                                    }
                                @endphp
                                <span> {{ $price_after . " " . config('app.currency') }}</span>
                            </div>
                        </div>
                        <div class="group-buttons">
                            <div class="quantity">
                                <div class="control">
                                    <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                    <input type="text" data-step="1" data-min="0" value="1" title="Qty"
                                           class="input-qty qty" size="4">
                                    <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                </div>
                            </div>
                            <button class="add_to_cart_button button" tabindex="0">{{__('Shop now')}}</button>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach

        </ul>
    </div>
</div>
<style>
.container {
    margin: 20px auto;
}

.custommenu-title-blog {
    text-align: center;
    margin-bottom: 30px;
    color: white; /* Adjust as needed */
}

.stelina-product {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.row {
    width: 100%;
    margin: 0;
}

.product-item {
    margin-bottom: 30px; /* Spacing between rows */
    padding: 10px; /* Optional padding */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background-color: #fff; /* Adjust background as needed */
}

.product-thumb {
    position: relative;
}

.product-top {
    position: relative;
}

.product-inner {
    text-align: center; /* Center the text */
}

.product-name {
    font-size: 1.2rem;
    margin: 10px 0;
}

.price {
    font-weight: bold;
    color: green; /* Adjust as needed */
}

.button {
    background-color: #007bff; /* Button color */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

</style>