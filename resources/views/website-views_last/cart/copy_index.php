@extends('layouts.website.master')
@section('title')
    {{__("Cart")}}
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
								{{__('Shopping Cart')}}
							</span>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title">
                        {{__('Shopping Cart')}}
                    </h3>
                    <div class="page-main-content">
                        <div class="shoppingcart-content">
                            <form action="shoppingcart.html" class="cart-form">
                                <table class="shop_table">
                                    <thead>
                                    <tr>
                                        <th class="product-remove"></th>
                                        <th class="product-thumbnail"></th>
                                        <th class="product-name"></th>
                                        <th class="product-price"></th>
                                        <th class="product-quantity"></th>
                                        <th class="product-subtotal"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($cartItems))
                                        @foreach($cartItems as $product_id=>$item)
                                            <?php if(isset($item['product'])) $item=$item['product']; ?>
                                             <tr class="cart_item">


                                         <td class="product-remove">
                                             <a href="#" class="remove" onclick="removeFromCart({{ $cartItems[$product_id]['id'] }})">×</a>
                                         </td>
                                            <td class="product-thumbnail">
                                                <a href="{{route('products.details',$item['id'])}}">
                                                    <img src="{{asset($item['image'])}}" alt="img"
                                                         class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                                </a>
                                            </td>
                                            <td class="product-name" data-title="Product">
                                                <a href="{{route('products.details',$item['id'])}}" class="title">{{$item['name']}}</a>
                                                <?php
                                                $variation = json_decode($item['variations']);
                                               if(!empty($item['variations'])){
                                                $type = $variation->type;
                                                }else{
                                                    $type='';
                                                }



                                                ?>
                                                <span class="attributes-select attributes-color">{{$type}}</span>

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
                                                             <a class="btn-number qtyminus quantity-minus" href="#" onclick="updateQuantity({{ $item['id'] }}, 'decrease')">-</a>
                                                             <input type="text" data-step="1" data-min="0" value="{{ $cartItems[$product_id]['quantity'] }}" title="Qty"
                                                                    class="input-qty qty" size="4" id="quantity-{{ $item['id'] }}">
                                                             <a class="btn-number qtyplus quantity-plus" href="#" onclick="updateQuantity({{ $item['id'] }}, 'increase')">+</a>
                                                         </div>
                                                     </div>
                                                 </td>

                                            <td class="product-price" data-title="Price">
												
                                                                       @php
                                                                           $price_after = $item['price']; // Initialize with the original price
                                                                           if ($item['discount_type'] == "percent") {
                                                                               $price_after -= ($item['price'] * $item['discount'] / 100);
                                                                           } else {
                                                                               $price_after -= $item['discount'];
                                                                           }
                                                                       @endphp
                                                        <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">
                                                                 {{$price_after." ".config('app.currency')}}
                                                            </span>
                                                        </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </form>
                            <!--<div class="control-cart">
                                <button class="button btn-continue-shopping" id="continue-shopping" style="background:#d78b07 !important;">
                                   {{__('Continue Shopping')}}
                                </button>
                                <button class="button btn-cart-to-checkout" id="checkout" style="background:#d78b07 !important;">
                                    {{__('Checkout')}}
                                </button>
                            </div>-->
                            <div class="control-cart" style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
    <button class="button btn-continue-shopping" id="continue-shopping" style="background: #ccc; color: #333;">
        {{ __('Continue Shopping') }}
    </button>

    <button class="button btn-cart-to-checkout attention-checkout" id="checkout">
        {{ __('Checkout') }}
    </button>
</div>

<style>
    .attention-checkout {
        background-color: #e74c3c !important; /* Bold red */
        color: white;
        font-weight: bold;
        padding: 0.8rem 1.6rem;
        border: none;
        border-radius: 6px;
        font-size: 1.1rem;
        box-shadow: 0 0 10px rgba(231, 76, 60, 0.4);
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.4);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(231, 76, 60, 0.6);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.4);
        }
    }
</style>

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
               // alert("jkfj");
                // Redirect to the checkout page
                window.location.href = "{{ route('checkout.index') }}"; // Adjust the route as necessary
            });
       // });
        function updateQuantity(productId, action) {
            let quantityInput = document.getElementById('quantity-' + productId);
            let currentQuantity = parseInt(quantityInput.value) || 0;

            if (action === 'increase') {
                //alert(currentQuantity);
                quantityInput.value = (currentQuantity);
                 quantity_num=currentQuantity+1;
            } else if (action === 'decrease' && currentQuantity > 0) {
                quantityInput.value = currentQuantity;
                quantity_num=currentQuantity-1;
            }

            // Send AJAX request to update the cart
            $.ajax({
                url: "{{ route('carts.cart.update') }}",
                method: 'POST',
                data: {
                    id: productId,
                    quantity:quantity_num , //quantityInput.value,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Handle success, e.g., update total price
                    $('.count-icon').empty();
                     $('.count-icon').text(quantity_num);
                    $('#cart-count').empty();
                     $('#cart-count').text(quantity_num);
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
