@extends('layouts.website.master')
@section('title')
    {{__("order details")}}
@endsection

@section('content')
    <main class="site-main  main-container no-sidebar">
        <div class="container">
            <div class="breadcrumb-trail breadcrumbs">
                <ul class="trail-items breadcrumb">
                    <li class="trail-item trail-begin">
                        <a href="">
								<span>
									{{__('Home')}}
								</span>
                        </a>
                    </li>
                    <li class="trail-item trail-end active">
							<span>
								{{__('Order details')}}
							</span>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title">
                        {{__('Details')}}
                    </h3>
                    <div class="page-main-content">
                        <div class="shoppingcart-content">

                                <table class="shop_table">
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail">{{__('img')}}</th>
                                        <th class="product-name">{{__('name')}}</th>
                                        <th class="product-price">{{__('price')}}</th>
                                        <th class="product-quantity">{{__('quantity')}}</th>
                                        <th class="product-subtotal">{{__('subtotal')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($cartItems))
                                        @foreach($cartItems as $product_id=>$item)


                                            <tr class="cart_item">
                                                <td class="product-thumbnail">
                                                    <a href="{{route('products.details',$item['id'])}}">
                                                        <img src="{{asset($item['food']['image'])}}" alt="img" style="width: 10rem !important;"
                                                             class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                                    </a>
                                                </td>
                                                <td class="product-name" data-title="Product">
                                                    <a href="{{route('products.details',$item['food_id'])}}" class="title">{{$item['food']['name']}}</a>
                                                </td>
                                            <!--<td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <div class="control">
                                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                        <input type="text" data-step="1" data-min="0" value="{{$cartItems[$product_id]['quantity']}}" title="Qty"
                                                               class="input-qty qty" size="4">
                                                        <a href="#" class="btn-number qtyplus quantity-plus" onclick="addToCart({{ $item['id']}}, $('.input-qty').val())">+</a>
                                                    </div>
                                                </div>
                                            </td>-->
                                                <td class="product-quantity" data-title="Quantity">
                                                    <div class="quantity">
                                                        <div class="control">

                                                            <input type="text" data-step="1" data-min="0"  readonly value="{{ $cartItems[$product_id]['quantity'] }}" title="Qty"
                                                                   class="input-qty qty" size="4" >

                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="product-price" data-title="Price">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">
                                                                 {{$item['price']." ".config('app.currency')}}
                                                            </span>

                                                        </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>

                        <!-- <div class="control-cart">
                                <button class="button btn-continue-shopping" id="continue-shopping">
                                    {{__('Continue Shopping')}}
                                </button>
                                <button class="button btn-cart-to-checkout" id="checkout">
                                    {{__('Checkout')}}
                                </button>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script type="text/javascript">
        //$(document).ready(function() {

        $('#continue-shopping').on('click', function() {
            // Redirect to the product listing page or home page
            window.location.href = "{{ route('products.list') }}"; // Adjust the route as necessary
        });

        $('#checkout').on('click', function() {
            alert("jkfj");
            // Redirect to the checkout page
            window.location.href = "{{ route('checkout.index') }}"; // Adjust the route as necessary
        });
        // });
        function updateQuantity(productId, action) {
            let quantityInput = document.getElementById('quantity-' + productId);
            let currentQuantity = parseInt(quantityInput.value) || 0;

            if (action === 'increase') {
                quantityInput.value = currentQuantity ;
            } else if (action === 'decrease' && currentQuantity > 0) {
                quantityInput.value = currentQuantity ;
            }

            // Send AJAX request to update the cart
            $.ajax({
                url: "{{ route('carts.cart.update') }}",
                method: 'POST',
                data: {
                    id: productId,
                    quantity: quantityInput.value,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Handle success, e.g., update total price
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr.responseText);
                }
            });
        }

        function removeFromCart(productId) {
            // Send AJAX request to remove item from cart
            $.ajax({
                url: "{{ route('carts.cart.remove') }}",
                method: 'POST',
                data: {
                    id: productId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Remove item from the DOM or reload cart
                    location.reload(); // Example: reload the page to refresh cart
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection
