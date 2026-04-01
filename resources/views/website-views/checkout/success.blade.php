@extends('layouts.website.master')

@section('title')
    {{ __("Success Order") }}
@endsection

@section('content')
<style>
    .end-checkout-wrapp {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
        padding: 40px 15px;
        background-color: #f8f9fa;
    }
    .end-checkout {
        background: #fff;
        border-radius: 15px;
        padding: 40px 30px;
        text-align: center;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-top: 5px solid #28a745;
    }
    .end-checkout .icon {
        width: 100px;
        height: 100px;
        background-color: #28a745;
        border-radius: 50%;
        margin: 0 auto 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: popIn 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }
    .end-checkout .icon::before {
        content: '\f00c'; /* FontAwesome check icon */
        font-family: 'FontAwesome';
        font-size: 50px;
        color: #fff;
    }
    @keyframes popIn {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .title-checkend {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }
    .sub-title {
        font-size: 16px;
        color: #555;
        line-height: 1.8;
        margin-bottom: 30px;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        padding: 15px 0;
    }
    .sub-title label {
        font-weight: 600;
        color: #333;
    }
    .sub-title span {
        font-weight: 500;
        color: #dca716;
    }
</style>
    <div class="end-checkout-wrapp">
        <div class="end-checkout checkout-form">
            <div class="icon">
            </div>
            <h3 class="title-checkend">
               {{__('Congratulation! Your order has been processed.')}}
            </h3>
            <div class="sub-title">
                <label>{{__('Order ID')}}:</label>
                <span>{{$orderId}}</span>
                <br>
                <label>{{__('Total Amount')}}:</label>
                <span>{{$totalAmount}} {{$currency}}</span>
            </div>
            <a href="{{route('home.index')}}" class="button btn-return">{{__('Return to Store')}}</a>
        </div>
    </div>


    @endsection
    
   @section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Only push the event if it came from the checkout page, to avoid duplicates on refresh.
    if (sessionStorage.getItem('purchase_event_pushed') === 'true') {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: "custom_purchase",
            ecommerce: {
                transaction_id: "{{ $orderId }}",
                value: {{ $totalAmount }},
                subtotal: {{ $subtotal }},
                total: {{ $totalAmount }},
                tax: {{ $tax }},
                shipping: {{ $shipping }},
                User_data: {
                    Hashed_phone: "{{ $hashedPhone }}",
                    Hashed_email: "{{ $hashedEmail }}"
                },
                items: [
                    @foreach($items as $item)
                        @php
                            $product = $item['product'] ?? $item;
                            $variation = json_decode($product['variations'] ?? '{}', true);
                            $variant = $variation['type'] ?? ($product['variant'] ?? 'N/A');
                            $price_after = $product['price'];
                            if ($product['discount_type'] === 'percent') {
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
                            quantity: {{ $item['quantity'] ?? 1 }}
                        }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]
            }
        });
        // Clear the flag to prevent pushing on page refresh
        sessionStorage.removeItem('purchase_event_pushed');
    }
});
</script>
@endsection
