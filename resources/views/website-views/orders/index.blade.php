@extends('layouts.website.master')
@section('title')
    {{__("Orders")}}
@endsection

@push('style')
<style>
    .page-title {
        text-align: center;
        font-size: 2.5rem;
        color: var(--main-black, #232323);
        margin-bottom: 2rem;
        border-bottom: 2px solid var(--main-gold, #bfa15a);
        padding-bottom: 10px;
    }
    .order-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px #0000001a;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px #0000002a;
    }
    .order-card-header {
        background-color: #f8f9fa;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #dee2e6;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .order-card-header div {
        font-size: 0.95rem;
    }
    .order-card-header .order-id {
        font-weight: bold;
        color: var(--main-black, #232323);
    }
    .order-card-header .order-date, .order-card-header .order-total {
        color: #6c757d;
    }
    .order-status {
        padding: 5px 15px;
        border-radius: 20px;
        color: #fff;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: capitalize;
    }
    .status-pending { background-color: #ffc107; color: #333; }
    .status-confirmed, .status-processing, .status-out_for_delivery { background-color: #007bff; }
    .status-delivered { background-color: #28a745; }
    .status-returned, .status-failed, .status-canceled { background-color: #dc3545; }

    .order-card-footer {
        padding: 1rem 1.5rem;
        background-color: #f8f9fa;
        text-align: right;
    }
    .btn-view-details {
        background-color: var(--main-gold, #bfa15a);
        color: white !important;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.2s;
        font-weight: 500;
    }
    .btn-view-details:hover {
        background-color: var(--main-black, #232323);
        color: white !important;
    }
    .no-orders {
        text-align: center;
        padding: 3rem;
        background: #fff;
        border-radius: 12px;
    }
</style>
@endpush

@section('content')
    <div class="main-content main-content-product no-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="{{route('home.index')}}">{{__('Home')}}</a>
                            </li>
                            <li class="trail-item trail-end active">
                                {{__('My Orders')}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <h1 class="page-title">{{__('My Orders')}}</h1>
            <div class="row">
                <div class="content-area col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="site-main">
                        <div class="shop-top-control">
                            <form class="filter-choice select-form">
                                <span class="title">{{__('Sort by')}}:</span>
                                <select title="by" data-placeholder="{{__('Default sorting')}}" class="chosen-select" id="order-filter">
                                    <option value="">{{__('All Orders')}}</option>
                                    <option value="current_order" @if(request('current_order')) selected @endif>{{__('current_order')}}</option>
                                    <option value="latest_order" @if(request('latest_order')) selected @endif>{{__('delivered_order')}}</option>
                                    <option value="canceled" @if(request('status') == 'canceled') selected @endif>{{__('canceled_order')}}</option>
                                </select>
                            </form>
                        </div>

                        <div id="orders-list-container">
                            @forelse($list as $order)
                                <div class="order-card">
                                    <div class="order-card-header">
                                        <div>
                                            <span class="order-id">{{__('Order')}} #{{$order->id}}</span>
                                        </div>
                                        <div>
                                            <span class="order-date">{{__('Placed on')}}: {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="order-total">{{__('Total')}}: {{ $order->order_amount }} {{config('app.currency')}}</span>
                                        </div>
                                        <div>
                                            <span class="order-status status-{{$order->order_status}}">{{__($order->order_status)}}</span>
                                        </div>
                                    </div>
                                    <div class="order-card-footer">
                                        <a href="{{ route('order.details', ['id' => $order->id]) }}" class="btn-view-details">{{__('View Details')}}</a>
                                    </div>
                                </div>
                            @empty
                                <div class="no-orders">
                                    <h3>{{__('You have no orders yet.')}}</h3>
                                    <p>{{__('Start shopping to see your orders here.')}}</p>
                                    <a href="{{route('products.list')}}" class="btn-view-details">{{__('Shop Now')}}</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#order-filter').on('change', function(event) {
                event.preventDefault();
                var filterValue = $(this).val();
                var url = '{{route('order.order-list')}}';

                if (filterValue) {
                    url += '?' + (filterValue === 'canceled' ? 'status' : filterValue) + '=' + (filterValue === 'canceled' ? 'canceled' : 1);
                }
                
                window.location.href = url;
            });
        });
    </script>
@endsection