@extends('layouts.website.master')

@section('title')
    {{ __("Success Order") }}
@endsection

@section('content')
<style>
	.end-checkout .icon::before {
		content: url("../public/website/assets/images/icon-checkout.png")!important;
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
                </br>
                <label>{{__('Total Amount')}}:</label>
                <span>{{$totalAmount}} {{$currency}}</span>
                </br>
            </div>
            <a href="{{route('home.index')}}" class="button btn-return">Return to Store</a>
        </div>
    </div>


    @endsection
    
   @section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    if (sessionStorage.getItem('purchase_event_pushed') === 'true') {
        // Clear the flag to allow future purchases
        sessionStorage.removeItem('purchase_event_pushed');
        return;
    }

    // If flag is not set, push the purchase event
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
});
</script>
@endsection


