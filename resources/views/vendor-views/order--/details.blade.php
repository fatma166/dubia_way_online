@extends('layouts.vendor.master')
@section('title')
    {{__("details order")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">الطلبات</a>
                        </li>
                        <li class="breadcrumb-item active">تفاصيل الطلب</li>
                    </ol>
                </div>
                <h4 class="page-title">تفاصيل الطلب</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">تتبع الطلب</h4>
                    <div class="col-auto">
                        <select class="form-select form-select-sm form change_status_order" id="change_status" status_id="{{$order->id}}">
                            <optgroup label="اختر الحاله"></optgroup>
                            <option value="confirmed" @if($order->order_status=='confirmed') selected @endif >تاكيد الطلب</option>
                            <option value="processing" @if($order->order_status=='processing') selected @endif >تحضير الطلب</option>
                            <option value="picked_up" @if($order->order_status=='picked_up') selected @endif >شحن الطلب</option>
                            <option value="delivered" @if($order->order_status=='delivered') selected @endif>توصيل الطلب</option>
                        </select>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <h5 class="mt-0">رقم الطلب :</h5>
                                <p>{{$order->id}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6"></div>
                    </div>
                    <div class="track-order-list">
                        <ul class="list-unstyled">
                            <li class="completed">
                                <h5 class="mt-0 mb-1">تم تأكيد الطلب</h5>
                                <p class="text-muted">{{\Carbon\Carbon::parse($order->confirmed)->translatedFormat('l j F Y')}}<small class="text-muted">{{\Carbon\Carbon::parse($order->confirmed)->translatedFormat('H:i:s')}}</small>
                                </p>
                            </li>
                            <li class="completed">
                                <h5 class="mt-0 mb-1">يتم تحضير الطلب</h5>
                                <p class="text-muted">{{\Carbon\Carbon::parse($order->processing)->translatedFormat('l j F Y')}}<small class="text-muted">{{\Carbon\Carbon::parse($order->processing)->translatedFormat('H:i:s')}}</small>
                                </p>
                            </li>
                            <li>
                                <span class="active-dot dot"></span>
                                <h5 class="mt-0 mb-1">تم الشحن</h5>
                                <p class="text-muted">{{\Carbon\Carbon::parse($order->picked_up)->translatedFormat('l j F Y')}}<small class="text-muted">{{\Carbon\Carbon::parse($order->picked_up)->translatedFormat('H:i:s')}}</small>
                                </p>
                            </li>
                            <li>
                                <h5 class="mt-0 mb-1"> تم التوصيل</h5>
                                @if($order->delivered==null)
                                <p class="text-muted">متوقع التوصيل في خلال{{$order->restaurant->delivery_time}} </p>
                                    @else
                                    <p class="text-muted">{{\Carbon\Carbon::parse($order->delivered)->translatedFormat('l j F Y')}}<small class="text-muted">{{\Carbon\Carbon::parse($order->delivered)->translatedFormat('H:i:s')}}</small>
                                @endif
                            </li>
                        </ul>
                        <!-- <div class="text-center mt-4"><a href="#" class="btn btn-primary">تفاصيل الطلب</a></div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">عناصر الطلب</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-centered mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>اسم المنتج</th>
                                <th>صورة المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الإجمالي</th>
                            </tr>
                            </thead>
                            <tbody>
                             @php $total_price=0;@endphp
                            @foreach($order->details as $detail)
                                @php
                                $total_price+=$detail->price*$detail->quantity;
                               @endphp
                            <tr>
                                <th scope="row">{{(json_decode($detail->food_details))->name}}</th>
                                <td>
                                    <img src="{{asset((json_decode($detail->food_details))->image)}}" alt="product-img" height="32">
                                </td>
                                <td>{{$detail->quantity}}</td>
                                <td>{{$detail->price}}</td>
                                <td>{{$detail->quantity*$detail->price}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th scope="row" colspan="4" class="text-end">المجموع الأولي :</th>
                                <td>
                                    <div class="fw-bold">{{$total_price}} {{__(config('app.currency'))}} </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="4" class="text-end">خصم الكوبون  :</th>
                                <td>{{$order->coupon_discount_amount}} {{__(config('app.currency'))}}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="4" class="text-end">ثمن التوصيل :</th>
                                <td>{{$order->delivery_charge}} {{__(config('app.currency'))}}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="4" class="text-end">رسوم الخدمة :</th>
                                <td>0 {{__(config('app.currency'))}}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="4" class="text-end">المجموع النهائي :</th>
                                <td>
                                    <div class="fw-bold">{{$order->order_amount}}  {{__(config('app.currency'))}}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">تفاصيل عنوان العميل</h4>
                    <h5 class="font-family-primary fw-semibold">{{(isset($order->customer_address->contact_person_name)?$order->customer_address->contact_person_name:'')}}</h5>
                    <p class="mb-2">
                        <span class="fw-semibold me-2">العنوان :</span>  الدور رقم {{isset($order->customer_address->floor)?$order->customer_address->floor:''}}- منزل رقم  {{isset($order->customer_address->house)?$order->customer_address->house:''}}- {{isset($order->customer_address->address)?$order->customer_address->address:''}}- {{isset($order->customer_address->road)?$order->customer_address->road:''}}
                    </p>
                    <p class="mb-2">
                        <span class="fw-semibold me-2">رقم الهاتف</span> {{isset($order->customer_address->contact_person_number)?$order->customer_address->contact_person_number:''}}
                    </p>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">تفاصيل الدفع</h4>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <p class="mb-2">
                                <span class="fw-semibold me-2">طريقة الدفع :</span>{{$order->payment_method}}
                            </p>
                            <p class="mb-2">
                                <span class="fw-semibold me-2">الرقم المرجعي</span>  {{$order->transaction_reference}}
                            </p>
                            <p class="mb-2">
                                <span class="fw-semibold me-2"> حاله الدفع :</span> {{$order->payment_status}}
                            </p>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">تفاصيل الشحن</h4>
                    <div class="text-center">
                        <i class="mdi mdi-truck-fast h2 text-muted"></i>
                        <h5>
                            <b>UPS Delivery</b>
                        </h5>
                        <p class="mb-1">
                            <span class="fw-semibold">Order ID :</span> {{$order->id}}
                        </p>
                        <p class="mb-0">
                            <span class="fw-semibold">Payment Mode :</span> COD
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#change_status').on('change', function() {

                $.ajax({
                    url: '{{route('vendor.order.change-status')}}',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: $('#change_status').attr('status_id'),
                        status: this.value,
                        type:'nottoggle'
                    },
                    success: function(response) {
                        //  console.log(response);
                       location.reload();
                        // do something with the response data
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        // handle the error case
                    }
                });
            });
        });
    </script>



@endsection
