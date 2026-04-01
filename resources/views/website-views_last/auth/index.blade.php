@extends('layouts.website.master')
@section('title')
  @if($type=="login")  {{__("Login")}} @else {{__("Register")}} @endif
@endsection

@section('content')
    <div class="main-content main-content-login">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{route('home.index')}}">{{__('Home')}}</a>
                            </li>
                            <li class="trail-item trail-end active">
                                @if($type=="login")  {{__("login")}} @else {{__("register")}} @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="content-area col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <h3 class="custom_blog_title">
                            @if($type=="login")  {{__("login")}} @else {{__("register")}} @endif
                        </h3>
                        <div class="customer_login">
                            <div class="row">

                                @if($type=="login")   @include('website-views.auth.loginForm') @else @include('website-views.auth.registerForm') @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        //$(document).ready(function() {

        $('.login_submit').on('click', function() {
            alert("klkl");
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
</script>