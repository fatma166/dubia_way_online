@extends('layouts.website.master')
@section('title')
    {{__("order details")}}
@endsection

@push('style')
<style>
    .order-details-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 15px;
    }
    .page-title {
        text-align: center;
        font-size: 2.5rem;
        color: var(--main-black, #232323);
        margin-bottom: 2rem;
        border-bottom: 2px solid var(--main-gold, #bfa15a);
        padding-bottom: 10px;
    }
    .order-summary-card, .order-items-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px #0000001a;
        margin-bottom: 2rem;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }
    .card-header {
        background-color: #f8f9fa;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #dee2e6;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--main-black, #232323);
    }
    .card-body {
        padding: 1.5rem;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        color: #555;
    }
    .summary-item .label {
        font-weight: 500;
    }
    .summary-item.total {
        font-weight: bold;
        font-size: 1.1rem;
        color: var(--main-black, #232323);
        border-top: 1px solid #dee2e6;
        margin-top: 1rem;
        padding-top: 1rem;
    }

    .product-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .product-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .product-image img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }
</style>
@endpush

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
            <div class="order-details-container">
                <h1 class="page-title">{{__('Order Details')}}</h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="order-items-card">
                            <div class="card-header">
                                {{__('Items in your order')}}
                            </div>
                            <div class="card-body">
                                @php $total = 0; $sub_total = 0; @endphp
                                @if(!empty($cartItems))
                                    @foreach($cartItems as $item)
                                        @php $sub_total += $item['price'] * $item['quantity']; @endphp
                                        <div class="product-item">
                                            <div class="product-image">
                                                <a href="{{route('products.details', $item['food_id'])}}">
                                                    <img src="{{asset($item['food']['image'])}}" alt="{{$item['food']['name']}}">
                                                </a>
                                            </div>
                                            <div class="product-details flex-grow-1">
                                                <a href="{{route('products.details', $item['food_id'])}}" class="product-name">{{$item['food']['name']}}</a>
                                                <div class="product-qty-price">
                                                    <span>{{__('Qty')}}: {{$item['quantity']}}</span>
                                                </div>
                                            </div>
                                            <div class="product-price">
                                                <strong>{{$item['price'] * $item['quantity']}} {{config('app.currency')}}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="summary-item total">
                                    <span class="label">{{__('Total')}}</span>
                                    <span class="value">{{$sub_total}} {{config('app.currency')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
