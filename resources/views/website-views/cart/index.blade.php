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
                                             <a href="#" class="remove" onclick="removeFromCart({{ $cartItems[$product_id]['id'] }})" title="{{__('Remove')}}">
                                                 <i class="fa fa-trash" style="color: #dc3545; font-size: 1.2rem;"></i>
                                             </a>
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
                            
<div class="control-cart" style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee;">
    <button class="button btn-continue-shopping" id="continue-shopping">
        <i class="fa fa-shopping-bag"></i>
        {{ __('Continue Shopping') }}
    </button>

    <button class="button btn-cart-to-checkout attention-checkout" id="checkout">
        {{ __('Checkout') }} <i class="fa fa-check-circle"></i>
    </button>
</div>

<style>
    /* --- General Table Styling --- */
    .cart-form .shop_table {
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        overflow: hidden; /* To respect border-radius */
    }
    .cart-form .shop_table thead {
        display: table-header-group; /* Show header */
        background-color: #f9f9f9;
        font-weight: 600;
        color: #444;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    .cart-form .shop_table thead th {
        padding: 18px 15px;
        text-align: center;
        border-bottom: 2px solid #eee;
    }
    .cart-form .shop_table thead .product-name {
        text-align: right;
    }
    .cart-form .shop_table tbody tr.cart_item td {
        padding: 25px 15px;
        vertical-align: middle;
        text-align: center;
    }
    .cart-form .shop_table .product-name {
        text-align: right;
    }
    .cart-form .shop_table .product-name a.title {
        font-size: 1.1rem;
        font-weight: 600;
    }
    .cart-form .shop_table .product-thumbnail img {
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        width: 90px;
        height: auto;
    }
    .cart-form .shop_table .product-remove .fa-trash {
        transition: color 0.3s, transform 0.3s;
    }
    .cart-form .shop_table .product-remove a:hover .fa-trash {
        color: #a02020 !important;
        transform: scale(1.2);
    }

    /* --- Quantity Input Styling --- */
    .quantity .control {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 25px;
        overflow: hidden;
        width: 120px;
        height: 42px;
        margin: 0 auto;
        box-shadow: none;
        background: #fff;
    }
    .quantity .control .btn-number {
        font-size: 20px;
        font-weight: 400;
        width: 35px;
        height: 100%;
        background-color: transparent;
        color: #888;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .quantity .control .btn-number:hover {
        background-color: #dca716; /* Theme color */
        color: #fff;
    }
    .quantity .control .input-qty {
        width: 50px;
        height: 100%;
        border: none;
        border-left: 1px solid #eee;
        border-right: 1px solid #eee;
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        color: #333;
        background: transparent;
        padding: 0;
        -moz-appearance: textfield;
    }
    .quantity .control .input-qty::-webkit-outer-spin-button,
    .quantity .control .input-qty::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* --- Button Styling --- */
    .btn-continue-shopping {
        background: #f5f5f5 !important;
        color: #555 !important;
        border: 1px solid #e0e0e0 !important;
        padding: 0.9rem 1.8rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-continue-shopping:hover {
        background: #e9e9e9 !important;
        color: #222 !important;
        border-color: #d0d0d0 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .attention-checkout {
        background-color: #2ecc71 !important; /* Green */
        color: white;
        font-weight: bold;
        padding: 1rem 2rem;
        border: none;
        border-radius: 50px;
        font-size: 1.2rem;
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.4);
        animation: pulse 2s infinite;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        }
        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 15px rgba(46, 204, 113, 0);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
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
