@extends('layouts.vendor.master')
@section('title')
    {{__("details customer")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">العملاء</a>
                        </li>
                        <li class="breadcrumb-item active">تفاصيل العميل</li>
                    </ol>
                </div>
                <h4 class="page-title">تفاصيل العميل {{$user->f_name}}  {{$user->l_name}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{asset($user->image)}}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image" onerror="this.src='{{asset('assets/images/logo.png')}}'">
                    <h4 class="mb-0">{{$user->f_name}}   {{$user->l_name}}</h4>
                    <button type="button" class="btn btn-primary btn-xs waves-effect mb-2 waves-light">ارسال رسالة</button>
                    <div class="text-start mt-3">
                        <p class="text-muted mb-2 font-13">
                            <strong>البريد الإلكتروني</strong>
                            <span class="ms-2">{{$user->email}}</span>
                        </p>
                        <p class="text-muted mb-2 font-13">
                            <strong>رقم الهاتف :</strong>
                            <span class="ms-2">{{$user->phone}}</span>
                        </p>
                        <p class="text-muted mb-2 font-13">
                            <strong>العنوان : </strong>
                            <span class="ms-2">{{isset($user->addresses[0]->address)?$user->addresses[0]->address:''}}</span>
                        </p>
                        <p class="text-muted mb-2 font-13">
                            <strong>عدد الطلبات : </strong>
                            <span class="ms-2"> {{$user->orders_count}}</span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->
        <div class="col-lg-8 col-xl-8">
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
                    <th>اسم المكان</th>
                    <th>إجمالي الفاتورة</th>
                    <th>الحالة</th>
                    <th style="width: 85px;">الإجراء</th>
                </tr>
                </thead>
                <tbody>
                @if($user->orders->count()>0)
                @foreach($user->orders as $order)
                <tr>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheck2">
                            <label class="form-check-label" for="customCheck{{$order->id}}">&nbsp;</label>
                        </div>
                    </td>
                    <td> {{$order->id}} </td>
                    <td> {{\Carbon\Carbon::parse($order->creared_at)->translatedFormat('l j F Y ')}} </td>
                    <td class="table-user">
                        <img src="{{asset($order->logo)}}" alt="table-user" class="me-2 rounded-circle" onerror="this.src='{{asset('assets/images/logo.png')}}'">
                        <a href="javascript:void(0);" class="text-body fw-semibold"> {{$order->restaurant->name}}</a>
                    </td>
                    <td>  {{$order->amount}} </td>
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
                    <tr> <span>{{__('no orders found')}}</span></tr>
                @endif
                </tbody>
            </table>
        </div>
        <!-- end col -->
    </div>
    <!-- end row-->
@endsection
