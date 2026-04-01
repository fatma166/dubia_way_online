@extends('layouts.website.master')

@section('title')
    {{ __("Checkout") }}
@endsection

@section('content')
<style>
	.error-message {
    color: red; /* Change this to your desired color */
    font-size: 12px; /* Adjust size as needed */
    margin-top: 5px;
}

/* --- Enhanced Checkout Design --- */
.checkout-wrapp {
    padding: 20px 0;
}
.shipping-address-form-wrapp {
    background: #fff;
    border-radius: 12px;
    /* box-shadow: 0 5px 20px rgba(0,0,0,0.05); */
    padding: 20px;
}
.checkout-form .input-text {
    border: 1px solid #e0e0e0 !important;
    background-color: #f9f9f9 !important;
    border-radius: 8px !important;
    padding: 12px 15px !important;
    height: 48px !important;
    font-size: 15px;
    color: #333;
    width: 100%;
    transition: all 0.3s ease;
}
.checkout-form .input-text:focus {
    border-color: #2ecc71 !important;
    background-color: #fff !important;
    box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
    outline: none;
}
.checkout-form label.text {
    font-weight: 600;
    color: #444;
    margin-bottom: 8px;
    display: block;
    font-size: 14px;
}
.title-form {
    font-weight: 700;
    color: #222;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 15px;
}
.title-form::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background: #2ecc71;
}

/* Trust Badges */
.trust-badges-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
    flex-wrap: wrap;
}
.trust-badge {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    flex: 1;
    min-width: 150px;
    max-width: 250px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.trust-badge:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    border-color: #2ecc71;
}
.trust-badge i {
    font-size: 32px;
    color: #2ecc71;
    margin-bottom: 15px;
}
.trust-badge span {
    font-size: 14px;
    font-weight: 600;
    color: #555;
    line-height: 1.4;
}

/* --- Offers Banner --- */
.offers-banner {
    background: #dca716; /* Theme color */
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    margin: 20px 0 30px;
    text-align: center;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    box-shadow: 0 4px 15px rgba(220, 167, 22, 0.3);
    border: 2px dashed #fff;
}
.offers-banner i {
    font-size: 1.6rem;
    animation: tada 2.5s infinite;
}
@keyframes tada {
    0%{transform:scale(1)}10%,20%{transform:scale(.9) rotate(-3deg)}30%,50%,70%,90%{transform:scale(1.1) rotate(3deg)}40%,60%,80%{transform:scale(1.1) rotate(-3deg)}100%{transform:scale(1) rotate(0)}
}
.offers-slider-container {
    overflow: hidden;
    height: 60px; /* Adjust based on content */
    position: relative;
}
.offer-slide {
    display: none;
    animation: slideIn 0.5s ease-in-out;
    width: 100%;
    text-align: center;
}
.offer-slide.active {
    display: block;
}
@keyframes slideIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.coupon-code-style {
    background: #fff; color: #dca716; padding: 2px 8px; border-radius: 4px; font-weight: bold; border: 1px dashed #dca716;
}

</style>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin">
                            <a href="{{route('home.index')}}">{{ __('Home') }}</a>
                        </li>
                        <li class="trail-item trail-end active">
                            {{ __('Checkout') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <h3 class="custom_blog_title">{{__('Checkout')}}</h3>

        <!-- Offers Banner -->
        @php
            $currentDate = \Carbon\Carbon::now();
            
            // Fetch Active Offers
            $activeOffers = \Illuminate\Support\Facades\DB::table('offers')
                ->leftJoin('categories', 'categories.id','offers.category_id')
               // ->leftJoin('compilations', 'compilations.id', '=categories.compilation, '=', 'compilations.id')
                ->where('is_active', 1)
               // ->whereDate('start_date'<=', $currentDate)
               // ->whereDate('expire_date', '>=', $currentDate)
                ->select('offers.*', 'categories.name as category_name')
                ->get();

            // Fetch Active Coupons
            $activeCoupons = \Illuminate\Support\Facades\DB::table('coupons')
                ->whereDate('expire_date', '>=', $currentDate)
                ->get();
        @endphp

        @if($activeOffers->count() > 0 || $activeCoupons->count() > 0)
            <div class="offers-banner">
                <div class="offers-slider-container">
                    @foreach($activeOffers as $index => $offer)
                        <div class="offer-slide {{ $index == 0 ? 'active' : '' }}">
                            <i class="fa fa-gift"></i>
                            <span>
                                <strong>{{ $offer->type ?? __('Special Offer') }}:</strong>
                                
                                
                                @if(!empty($offer->category_name))
                                    {{ __('on') }} {{ $offer->category_name }}
                                    @else
                                    {{__('Special Offer')}}
                                @endif
                            </span>
                        </div>
                    @endforeach

                    @foreach($activeCoupons as $index => $coupon)
                        <div class="offer-slide {{ ($activeOffers->count() == 0 && $index == 0) ? 'active' : '' }}">
                            <i class="fa fa-ticket-alt"></i>
                            <span>
                                {{ __('Use coupon') }} 
                                <span class="coupon-code-style">{{ $coupon->code }}</span> 
                                {{ __('to get') }} 
                                {{ $coupon->discount_type == 'percent' ? $coupon->discount . '%' : $coupon->discount . ' ' . config('app.currency') }} 
                                {{ __('discount!') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="checkout-wrapp">
            <div class="shipping-address-form-wrapp">
                <div class="shipping-address-form checkout-form">
<div class="row-col-1 row-col">
    <h3 class="title-form">{{ __('Shipping Address') }}</h3>

    <div class="previous-addresses">
        @if(!empty($prev_addresses) && count($prev_addresses) > 0)
            @foreach($prev_addresses as $address)
                <div class="address-item">
                    <input type="radio" name="address" id="address-{{ $address->id }}"
                           value="{{ $address->id }}"
                           onclick="populateAddressForm('{{ $address->first_name }}', '{{ $address->last_name }}', '{{ $address->country }}', '{{ $address->city }}', '{{ $address->address }}','{{$address->contact_person_number}}','{{$address->city}}')">
                    <label for="address-{{ $address->id }}">
                        {{ $address->first_name }} {{ $address->last_name }}, {{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->zip_code }}
                    </label>
                    <button type="button" class="btn-delete-address" data-id="{{ $address->id }}">Delete</button>
                </div>
            @endforeach
        @else
            <p>{{ __('No previous addresses found.') }}</p>
        @endif
    </div>

    @if(empty($prev_addresses) || count($prev_addresses) == 0)
        {{-- Automatically show form --}}
        <div id="new-address-form" style="display: block;">
    @else
        {{-- Toggle form --}}
        <button type="button" id="add-new-address-btn" class="button">{{ __('Add New Address') }}</button>
        <div id="new-address-form" style="display: none;">
    @endif
        <h4>{{ __('New Address') }}</h4>
        <p class="form-row form-row-col-1">
            <label class="text">{{ __('name') }}</label>
            <input title="first" name="first_name" type="text" class="input-text @error('first_name') is-invalid @enderror" id="first-name" value="{{old('first_name')}}" required>
            <div class="error-message" id="first-name-error" style="display: none;"></div>
        </p>
        <p class="form-row form-row-col-3">
            <label class="text">{{ __('Phone') }}</label>
          
            <input title="phone" type="text" class="input-text" id="contact_person_number" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">

            <div class="error-message" id="contact-number-error" style="display: none;"></div>
        </p>
        <input type="hidden" id="country" name="country" value="1">
        <p class="form-row form-row-col-3">
            <label class="text">{{ __('City') }}</label>
            <input title="city" type="text" class="input-text" id="city" required>
            <div class="error-message" id="city-error" style="display: none;"></div>
        </p>
        <p class="form-row form-row-last">
            <label class="text">{{ __('Address') }}</label>
            <input title="address" type="text" class="input-text" id="address" required>
            <div class="error-message" id="address-error" style="display: none;"></div>
        </p>
    </div>
    <a href="#" id="cart-order" class="button button-payment attention-checkout">
        {{ __('Place Order') }} <i class="fa fa-arrow-right" style="margin-left: 10px;"></i>
    </a>
</div>


                    <div class="row-col-2 row-col">
                        <div class="your-order">
                            <h3 class="title-form">{{__('Your Order')}}</h3>
                            <ul class="list-product-order" style="border-bottom:2px solid">
                                @foreach($cartItems as $productId=>$cartItem)
                                <li class="product-item-order">
                                    <div class="product-thumb">
                                        @if(!isset($cartItem['product']))
                                            <a href="{{route('products.details',$cartItem['id'])}}"><img src="{{asset($cartItem['image'])}}" alt="img"></a>
                                        @else
                                            <a href="{{route('products.details',$cartItem['id'])}}"><img src="{{asset($cartItems[$productId]['product']['image'])}}" alt="img"></a>

                                        @endif
                                    </div>
                                    <div class="product-order-inner">
                                        <h5 class="product-name"><a href="{{route('products.details',$cartItem['id'])}}">@if(!isset($cartItem['product'])){{$cartItem['name']}}@else {{$cartItems[$productId]['product']['name']}} @endif</a></h5>
                                       <!-- <span class="attributes-select attributes-color">Black,</span>
                                        <span class="attributes-select attributes-size">XXL</span>-->
                                        <div class="price">
                                            @php
                                            if(isset($cartItem['product'])){
                                            $cartItem=$cartItem['product'];
                                            }else{
                                            $cartItem=$cartItem;
                                            }
                                                $price_after = $cartItem['price']; // Initialize with the original price
                                                if ($cartItem['discount_type'] == "percent") {
                                                    $price_after -= ($cartItem['price'] * $cartItem['discount'] / 100);
                                                } else {
                                                    $price_after -= $cartItem['discount'];
                                                }
                                            @endphp
                                            {{$price_after." ".config('app.currency')}} <span class="count">x {{$cartItems[$productId]['quantity']}}</span></div>
                                  
                                    </div>
                                </li>
                                @endforeach
                                <label style="display: none;">{{__('Coupon Code')}}</label>
                                <input id="coupon_code" name="coupon_code" style="display: none;"
    @if(($cartItems[$productId]['quantity']) > 2) disabled @endif />

                                    <p></p>
                                <div><span class="coupon_message"></span></div>
                                <label>{{__('Coupon Discount')}}:</label>
                                <span class="discount_am"></span>
								</br>
								@if(isset($offer_discount))
								<label>{{__('Offer Discount')}}:</label>
                                <span>{{$offer_discount}}</span>
								</br>
							    @endif
								
                                <label>{{__('Shipping Fees')}}:</label>
                                <span>{{__('Free')}}</span>
								</br>
								<label>{{__('Payment Method')}}:</label>
                                <span>{{__('Cash On Delivery')}}</span>
								
								
                            </ul>
                            <div class="order-total" style="padding-top:20px;">
                                <span class="title">{{__('Total Price:')}}</span>
                                <span class="total-price">{{$totalPrice." ".config('app.currency')}}</span>

                            </div>
                            
           <div style="background: #fff8e1; border: 1px solid #ffe082; border-radius: 8px; padding: 1.5rem; margin-top: 2rem !important;">
    <h3 style="color: #f39c12; font-weight: bold; text-align: center; margin-bottom: 15px;">
        ✨ {{ __('خليك فاكر') }} ✨
    </h3>

    <ul style="direction: rtl; text-align: right; list-style: none; padding: 0; margin: 0;">
        <li style="font-size: 1.1rem; margin-bottom: 10px; color: #555;"><i class="fa fa-check-circle" style="color: #f39c12; margin-left: 8px;"></i> شحن مجاني لأي طلب</li>
        <li style="font-size: 1.1rem; margin-bottom: 10px; color: #555;"><i class="fa fa-check-circle" style="color: #f39c12; margin-left: 8px;"></i> الدفع عند الاستلام</li>
        <li style="font-size: 1.1rem; margin-bottom: 10px; color: #555;"><i class="fa fa-check-circle" style="color: #f39c12; margin-left: 8px;"></i> معاينة المنتج مع المندوب</li>
        <li style="font-size: 1.1rem; margin-bottom: 0; color: #555;"><i class="fa fa-check-circle" style="color: #f39c12; margin-left: 8px;"></i> استبدال او استرجاع خلال 3 أيام</li>
    </ul>
</div>

                        </div>
                    </div>
                </div>
            </div>

<style>
    .attention-checkout {
        background: linear-gradient(45deg, #2ecc71, #27ae60) !important;
        color: white;
        font-weight: bold;
        padding: 1.2rem 2rem;
        border: none;
        border-radius: 50px;
        font-size: 1.3rem;
        box-shadow: 0 10px 20px rgba(46, 204, 113, 0.3);
        animation: pulse 2s infinite;
        display: block;
        width: 100%;
        max-width: 400px;
        margin: 20px auto 0;
        text-align: center;
        text-decoration: none;
        transition: transform 0.3s;
        clear: both;
    }
    .attention-checkout:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(46, 204, 113, 0.4);
        color: white;
    }
    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        }
        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 20px rgba(46, 204, 113, 0);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
        }
    }
</style>
<div class="trust-badges-container">
    <div class="trust-badge">
        <i class="fa fa-truck" aria-hidden="true"></i>
        <span>شحن سريع ومجاني</span>
    </div>
    <div class="trust-badge">
        <i class="fa fa-money-bill-wave" aria-hidden="true"></i>
        <span>{{__('cash_on_delivery')}}</span>
    </div>
    <div class="trust-badge">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        <span>معاينة المنتج عند الاستلام</span>
    </div>
</div>

        </div>
    </div>
    <style>
        .custom-swal {
            background-color: rgb(171, 142, 102); /* Change to your desired background color */
            color: white; /* Change text color if necessary */
        }
        .swal2-popup {
            background-color: rgb(243, 243, 243); /* Change modal background color */
        }

        .swal2-title, .swal2-content {
            color: #403131 !important;
        }
        div:where(.swal2-container) div:where(.swal2-html-container){
        color:#464343 !important;
        }
    </style>

    <script>
        document.getElementById('coupon_code').addEventListener('keyup', function() {
            var couponCode = $('#coupon_code').val().trim();
              //alert(couponCode);
            // Clear the coupon message if the input is empty or null
            if (couponCode === "") {

                $(".coupon_message").text("");
            }else{
                $.ajax({
                    url: "{{ route('checkout.check-coupon') }}",
                    method: 'POST',
                    data: {
                        coupon_code:couponCode,
                        cart_items: '{{json_encode($cartItems)}}',
                        //quantity: quantityInput.value,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if(response.status==true||response.status=="true"){
                             $(".coupon_message").text();
                              $(".discount_am").text();
                            //$(".coupon_message").text("{{__('coupon success')}}");
                           // var base_total_price= $(".total-price").val();
$(".coupon_message").text("{{__('coupon success')}}");
 $(".coupon_message").css({"color":"green","font-size":"3.2rem"});
        var base_total_price = $(".total-price").val();
        $(".discount_am").text(response.coupon_discount_amount);

        // Update total price with strikethrough and new price
        $(".total-price").html(
            '<del style="font-size: 1.5rem">' + base_total_price + '</del>' +
            ' <ins>' + response.total_price + ' LE</ins>'
        );
        $(".total-price").css({"color": "green", "font-size": "3rem"});
                        }else{
                              $(".discount_am").text();
                            $(".coupon_message").text("{{__('coupon failed')}}");
                            $(".coupon_message").css({"color":"red","font-size":"3.2rem"});
                            $('#coupon_code').text("");
                        }
                        // Handle success, e.g., update total price

                    },
                    error: function(xhr) {
                        // Handle error
                        console.log(xhr.responseText);
                    }
                });
            }

        });
        /*document.getElementById('add-new-address-btn').addEventListener('click', function() {
            const newAddressForm = document.getElementById('new-address-form');
            newAddressForm.style.display = newAddressForm.style.display === 'none' ? 'block' : 'none';
        });*/
        
        const addAddressBtn = document.getElementById('add-new-address-btn');
if (addAddressBtn) {
    addAddressBtn.addEventListener('click', function() {
        const newAddressForm = document.getElementById('new-address-form');
        newAddressForm.style.display = newAddressForm.style.display === 'none' ? 'block' : 'none';
    });
}


        function populateAddressForm(firstName, lastName, country, city, address,phone) {
            document.getElementById('first-name').value = firstName + ' ' + lastName;
            document.getElementById('country').value = country; // You may need to adjust this based on how countries are rendered
            document.getElementById('city').value = city;
            document.getElementById('address').value = address;
			document.getElementById('contact_person_number').value =phone;
        }

        // JavaScript for handling address deletion
        document.querySelectorAll('.btn-delete-address').forEach(button => {
            button.addEventListener('click', function() {
                const addressId = this.getAttribute('data-id');
                // Make an AJAX call to delete the address
                fetch(`/delete-address/${addressId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            // Remove the address from the UI
                            this.closest('.address-item').remove();
                        } else {
                            alert('Failed to delete address');
                        }
                    });
            });
        });


        document.getElementById('cart-order').addEventListener('click', function(e) {
            //alert("vgjhhgj");
                e.preventDefault();
                let selectedAddressId = document.querySelector('input[name="address"]:checked');
                let newAddressDetails = {
                    first_name: document.getElementById('first-name').value,
                    last_name: '.',
                    country: document.getElementById('country').value,
                    city: document.getElementById('city').value,
                    address: document.getElementById('address').value,
					contact_person_number:document.getElementById('contact_person_number').value,
					contact_person_name:document.getElementById('first-name').value,
					
                };
			// Clear previous error messages
				document.querySelectorAll('.error-message').forEach(function(el) {
					el.style.display = 'none'; // Hide all error messages
				});
                 let hasError = false;
                // Check if a radio button is selected
                if (selectedAddressId) {
                    // Use the selected address ID
                    let addressId = selectedAddressId.value;
                    submitOrder({ address_id: addressId, new_address: null });
                }
                // Check if the new address form is filled out
                else if (newAddressDetails.first_name && newAddressDetails.country && newAddressDetails.city && newAddressDetails.address && (newAddressDetails.contact_person_number&&(/^\d{11}$/.test(newAddressDetails.contact_person_number)))) {
                    // Use the new address details
                    submitOrder({ address_id: null, new_address: newAddressDetails });
                } else {
                   // alert('{{__("Please select a shipping address or fill out the new address form.")}}');
					 let hasError = false;
              
				 document.getElementById('new-address-form').style.display = 'block';
        // Validate each field and show error if invalid
        if (!newAddressDetails.first_name) {
            document.getElementById('first-name-error').textContent = 'First Name is required.';
            document.getElementById('first-name-error').style.display = 'block';
            hasError = true;
        }
        if (!newAddressDetails.country) {
            document.getElementById('country-error').textContent = 'Country is required.';
            document.getElementById('country-error').style.display = 'block';
            hasError = true;
        }
        if (!newAddressDetails.city) {
            document.getElementById('city-error').textContent = 'City is required.';
            document.getElementById('city-error').style.display = 'block';
            hasError = true;
        }
        if (!newAddressDetails.address) {
            document.getElementById('address-error').textContent = 'Address is required.';
            document.getElementById('address-error').style.display = 'block';
            hasError = true;
        }
        
      /*  let phone = newAddressDetails.contact_person_number;
        let phoneErrorElement = document.getElementById('contact-number-error');
        
        if (!phone || phone.trim().length < 11) {
            alert(phone);
            phoneErrorElement.textContent = !phone ? 'Contact Number is required.' : 'Phone number must be at least 11 digits.';
            phoneErrorElement.style.display = 'block';
            hasError = true;
        } else {
            phoneErrorElement.style.display = 'none'; // Clear error if valid
        }*/
       /* if (!newAddressDetails.contact_person_number || newAddressDetails.contact_person_number.trim().length < 11) {
            //alert("fkdlf");
            document.getElementById('contact-number-error').textContent = 'Contact Number is required.';
            document.getElementById('contact-number-error').style.display = 'block';
            hasError = true;
        }*/
let phone = newAddressDetails.contact_person_number.trim();
let phoneErrorElement = document.getElementById('contact-number-error');

if (!phone) {
    phoneErrorElement.textContent = 'Contact Number is required.';
    phoneErrorElement.style.display = 'block';
    hasError = true;
} 
 if (!/^\d{11}$/.test(phone)) {
    phoneErrorElement.textContent = 'Phone number must be exactly 11 digits.';
    phoneErrorElement.style.display = 'block';
    hasError = true;
} else {
    phoneErrorElement.style.display = 'none';
}


// alert(hasError);
        // If there are no errors, submit the order
        if (!hasError) {
            submitOrder({ address_id: null, new_address: newAddressDetails });
        }
                }

            });


        function submitOrder(data) {
            // alert("iiiiiii");
            $.ajax({
                url: "{{ route('checkout.make-order') }}",
                method: 'POST',
                data: {
                    cart_items: '<?php echo json_encode($cartItems)?>',
                    coupon_code: $('#coupon_code').val(),
                    address: data.new_address || {}, // Use new address if available
                    address_id: data.address_id, // Use selected address ID if available
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                dataType: 'json',
            success: function(response) {
            if (response.status) {
                // Save to sessionStorage to prevent double push on success page
                sessionStorage.setItem('purchase_event_pushed', 'true');

                const successUrl = "{{ route('checkout.success') }}?order_id=" + response.data.order_id +
                    "&total_amount=" + response.data.total_amount +
                    "&currency=" + (response.data.currency || 'EGP');
                window.location.href = successUrl;
            }
        }
             ////   success: function(response) {
                    // Handle success, e.g., update total price
                   // alert('Order placed successfully!');
                    // Redirect or update UI as needed
                 ////   console.log(response);
                ///    if (response.status) {
						
				//////		const successUrl = "{{ route('checkout.success') }}?order_id=" + response.data.order_id + "&total_amount=" + response.data.total_amount + "&currency=" + (response.data.currency || 'EGP');
                  /////          window.location.href = successUrl;
                        // Show SweetAlert with order details
                       /* Swal.fire({
                            title: '{{__('Order Placed Successfully!')}}',
                            text: `Order ID: ${response.data.order_id}\n'{{__('Total Amount')}}': ${response.data.total_amount} ${response.data.currency || '{{__('EGP')}}'}`,
                            icon: 'success',
                            confirmButtonText: '{{__('Go to Home')}}',
                            showCancelButton: true,
                            cancelButtonText: '{{__('Continue Shopping')}}',
                            customClass: {
                                popup: 'custom-swal' // Apply the custom class to the popup
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to home page
                                window.location.href = "{{ route('home.index') }}";
                            } else {
                                // Optionally, you can refresh the page or do something else
                                window.location.href = "{{ route('carts.list-cart') }}";
                            }
                        });*/
                 ////   }
              /////  },
               /* error: function(response) {

                    // Handle error
                    Swal.fire({
                        title: '{{__('Error!')}}',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: '{{__('Okay')}}'
                    });
                }*/
            });
        }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
    // Compute delivery cost (if fixed, or replace with dynamic logic)
    const deliveryCost = 0.00;

    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        event: "custom_begin_checkout",
        ecommerce: {
            currency: "{{ config('app.currency') }}",
            value: {{ $totalPrice + 0.00}}, // Total price including delivery
            subtotal: {{ $totalPrice }}, // Subtotal before delivery
            total: {{ $totalPrice + ( 0.00) }}, // Explicit total
            delivery_method: {
                type: "Scheduled Delivery",
                cost:  0.00 
            },
            items: [
                @foreach($cartItems as $productId => $cartItem)
                    @php
                        $product = $cartItem['product'] ?? $cartItem;
                        $variation = json_decode($product['variations'] ?? '{}', true);
                        $variant = $variation['type'] ?? ($product['variant'] ?? 'N/A');
                        $price_after = $product['price'];
                        if ($product['discount_type'] == "percent") {
                            $price_after -= ($product['price'] * $product['discount'] / 100);
                        } else {
                            $price_after -= $product['discount'];
                        }
                        $price_after = round($price_after, 2);
                    @endphp
                    {
                        item_id: "{{ $product['id'] }}",
                        item_name: "{{ $product['name'] }}",
                        item_brand: "{{ $product['brand'] ?? $product['category'] ?? 'Brand' }}",
                        item_category: "{{ $product['category'] ?? 'General' }}",
                        item_variant: "{{ $variant }}",
                        price: {{ $price_after }},
                        quantity: {{ $cartItem['quantity'] ?? 1 }}
                    }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ]
        }
    });
});
</script>
<script>
    // Simple Slider Logic for Offers
    document.addEventListener("DOMContentLoaded", function() {
        let slides = document.querySelectorAll('.offer-slide');
        if(slides.length > 1) {
            let currentSlide = 0;
            setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }, 4000); // Change every 4 seconds
        }
    });
</script>

@endsection