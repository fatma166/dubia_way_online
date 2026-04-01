@extends('layouts.admin.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">الطلبات</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <!-- here right -->
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-2 mt-sm-0">
                                <!-- here left -->
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                            <thead>
                            <tr>
                                <th style="width: 20px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th>رقم الطلب</th>
                                <th>تاريخ الطلب</th>
                                <th>بيانات العميل</th>
                                <th>اسم المكان</th>
                                <th>إجمالي الفاتورة</th>
                                <th>الحالة</th>
                                <th style="width: 85px;">الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(($orders->count())>0)
                            @foreach($orders as $order)
                                @if(!isset($order->restaurant->name))

                                   @continue
                                @endif
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck{{$order->id}}">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td> {{$order->id}} </td>
                                <td> {{\Carbon\Carbon::parse($order->creared_at)->translatedFormat('l j F Y H:i:s')}}</td>
                                <td>@if(isset($order->restaurant->vendor->f_name)){{$order->restaurant->vendor->f_name}}   {{$order->restaurant->vendor->l_name}}<br>{{$order->restaurant->vendor->phone}}@else {{__('notfound')}} @endif</td>
                                <td class="table-user">
                                    <img src="{{asset($order->logo)}}" alt="table-user" class="me-2 rounded-circle" onerror="this.src='{{asset('assets/images/logo.png')}}'">
                                    <a href="javascript:void(0);" class="text-body fw-semibold">{{$order->restaurant->name}}</a>
                                </td>
                                <td>{{$order->order_amount}} </td>
                                <td>
                                    <span class="badge  @if($order->order_status=='pending') {{'bg-warning rounded-pill'}}@elseif($order->order_status=='delivered'){{'bg-soft-success text-success'}}@elseif($order->order_status=='canceled'){{'bg-danger rounded-pill '}}@elseif($order->order_status=='processing'){{'bg-warning rounded-pill'}}@endif">@if($order->order_status=='pending') {{__('pending')}}@elseif($order->order_status=='delivered'){{__('delivered')}} @elseif($order->order_status=='canceled'){{__('canceled')}}  @elseif($order->order_status=='processing'){{__('processing')}} @endif </span>
                                </td>
                                <td>
                                    <a href="{{route('admin.order.details',['id'=>$order->id])}}" class="action-icon">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                                {{__('no data available')}}
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if(!request()->filled("print"))
                        <div class="pagination pagination-rounded justify-content-end mb-0">
                            {!! $orders->withQueryString()->links() !!}
                        </div>
                    @endif
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
