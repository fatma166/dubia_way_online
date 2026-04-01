@extends('layouts.vendor.master')
@section('title')
    {{__("dashboard")}} - {{__("print invoice")}}
@endsection

@section('content')

<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
    <div class="card">
        <div class="card-header p-2">
            <a class="pt-2 d-inline-block" href="index.html" data-abc="true"> <img src="{{ asset("assets/images/logo-dark.png") }}" alt="" class="w-100 mb-3"
                                                                                                                style="max-height: 40px; object-fit: contain"></a>
            <div class="float-right"> <h3 class="mb-0">{{__('order number')}} {{$order->id}}</h3>
                <p class="text-muted">{{\Carbon\Carbon::parse($order->picked_up)->translatedFormat('l j F Y')}}<small class="text-muted">{{\Carbon\Carbon::parse($order->picked_up)->translatedFormat('H:i:s')}}</small></p></div>
        </div>
        <div class="card-body">
            <div class="row mb-4">

                <div class="col-sm-6 ">
                    <h3 class="mb-3">{{__('From')}}:</h3>
                    <h3 class="text-dark mb-1">{{$order->restaurant->name}}</h3>


                </div>
                <div class="col-sm-6">
                    <h3 class="mb-3">{{__('To')}}:</h3>
                    <h3 class="text-dark mb-1">{{__('address _ customer')}}</h3>
                    <div> {{isset($order->customer_address->floor)?$order->customer_address->floor:''}} , {{isset($order->customer_address->house)?$order->customer_address->house:''}} </div>
                    <div>{{isset($order->customer_address->address)?$order->customer_address->address:''}},{{isset($order->customer_address->road)?$order->customer_address->road:''}}</div>
                    <div>{{__('contact_person')}}: {{(isset($order->customer_address->contact_person_name)?$order->customer_address->contact_person_name:'')}}</div>
                    <div>{{__('phone')}}: {{isset($order->customer_address->contact_person_number)?$order->customer_address->contact_person_number:''}}</div>
                </div>
            </div>
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="center">#</th>
                        <th>{{__('Item')}}</th>
                        <th class="right">{{__('Price')}}</th>
                        <th class="center">{{__('Qty')}}</th>
                        <th class="right">{{__('Total')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php  $i=0; $total_price=0; @endphp
                    @foreach($order->details as $detail)
                        @php
                            $total_price+=$detail->price*$detail->quantity;
                        @endphp
                    <tr>
                        <td class="center">{{$i}}</td>
                        <td class="left strong">{{(json_decode($detail->food_details))->name}}</td>

                        <td class="right">{{$detail->price}}  {{__(config('app.currency'))}}</td>
                        <td class="center">{{$detail->quantity}}</td>
                        <td class="right">{{$detail->quantity*$detail->price}}  {{__(config('app.currency'))}}</td>
                    </tr>
                        @php $i++ @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5">
                </div>
                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">{{__('Subtotal')}}</strong>
                            </td>
                            <td class="right">{{$total_price}} {{__(config('app.currency'))}} </td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">{{__('coupon_discount')}}</strong>
                            </td>
                            <td class="right">{{$order->coupon_discount_amount}} {{__(config('app.currency'))}}</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">{{__('delivery_coast')}}</strong>
                            </td>
                            <td class="right">{{$order->delivery_charge}} {{__(config('app.currency'))}}</td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong class="text-dark">{{__('Total')}}</strong>
                            </td>
                            <td class="right">
                                <strong class="text-dark">{{$order->order_amount}}  {{__(config('app.currency'))}}</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--<div class="card-footer bg-white">
           <p class="mb-0">https://bastaat.app</p>
        </div>-->
    </div>
</div>
</body>
<style>
    body{

        background-color: #000;
    }

    .padding{

        padding: 2rem !important;
    }

    .card {
        margin-bottom: 30px;
        border: none;
        -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e6e6f2;
    }

    h3 {
        font-size: 20px;
    }

    h5 {
        font-size: 15px;
        line-height: 26px;
        color: #3d405c;
        margin: 0px 0px 15px 0px;
        font-family: 'Circular Std Medium';
    }

    .text-dark {
        color: #3d405c !important;
    }
</style>
@endsection