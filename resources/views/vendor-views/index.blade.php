@extends('layouts.vendor.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex align-items-center mb-3">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control border" id="dash-daterange">
                                <span class="input-group-text bg-blue border-blue text-white">
                          <i class="mdi mdi-calendar-range"></i>
                        </span>
                            </div>
                        </form>
                    </div>
                    <h4 class="page-title">مرحباً {{Auth::guard('vendor')->user()->f_name}} ,</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-primary">
                                    <i class="dripicons-wallet font-24 avatar-title text-primary"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">ر.س <span data-plugin="counterup">{{$data['monthly_order_amount']}}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">الأرباح</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-success">
                                    <i class="dripicons-basket font-24 avatar-title text-success"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <a href="{{route('vendor.order.index')}}">
                                        <h3 class="text-dark mt-1">
                                            <span data-plugin="counterup">{{$data['monthly_order_count']}}</span>
                                        </h3>
                                        <p class="text-muted mb-1 text-truncate">عدد الطلبات</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-info">
                                    <i class="dripicons-store font-24 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="{{route('vendor.product.index')}}">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">
                                            <span data-plugin="counterup">{{$data['monthly_product_count']}}</span>
                                        </h3>
                                        <p class="text-muted mb-1 text-truncate">عدد المنتجات</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-warning">
                                    <i class="dripicons-user-group font-24 avatar-title text-warning"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <a href="{{route('vendor.customer.index')}}">
                                        <h3 class="text-dark mt-1">
                                            <span data-plugin="counterup">{{$data['monthly_user_count']}}</span>
                                        </h3>
                                        <p class="text-muted mb-1 text-truncate">العملاء</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-8"></div>
            <!-- end col-->
            <div class="col-xl-4"></div>
            <!-- end col-->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pb-2">
                        <h4 class="header-title mb-3">الارباح والمبيعات الشهرية</h4>
                        <div dir="ltr">
                            <div id="sales-analytics" class="mt-4" data-colors="#1abc9c,#4a81d4"></div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">احدث الطلبات</h4>
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                <thead class="table-light">

                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>اسم صاحب الطلب</th>
                                    <th>السعر</th>
                                    <th>التاريخ</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($data['last_orders']->count()>0)

                                    @foreach($data['last_orders'] as $key=>$last_order)
                                       @if(!isset($last_order->customer->f_name))
                                           @continue
                                           @endif
                                        <tr>
                                    <td> {{$last_order->id}} </td>
                                    <td> {{$last_order->customer->f_name}}  {{$last_order->customer->l_name}}<br>{{$last_order->customer->phone}}
                                    </td>
                                    <td> {{$last_order->order_amount}} {{__
                                    (config('app.currency'))}}</td>
                                    <td> <small>{{\Carbon\Carbon::parse($last_order->creared_at)->translatedFormat('l j F Y H:i:s')}}</small> </td>
                                </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            {{__('no data available')}}
                                        </td>
                                    </tr>

                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">المنتجات الأكثر شراءاً</h4>
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap table-hover table-centered m-0">
                                <thead class="table-light">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>عدد الطلبات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($data['top_products']->count()>0)

                                    
                                    @foreach($data['top_products'] as $key=>$top_product)

                                        @if(!isset($top_product->name))

                                            @continue
                                        @endif
                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{$top_product->name}}</h5>
                                            </td>
                                            <td>{{$top_product->total_quantity}} طلبات </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            {{__('no data available')}}
                                        </td>
                                    </tr>

                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- end .table-responsive-->
                    </div>
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
@endsection
@push('script')
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <!-- Dashboar 1 init js-->
    <script src="{{asset('assets/js/pages/dashboard-1-vendor.init.js')}}"></script>
    <script>

        /*   flatpickr("#dash-daterange", {
               dateFormat: "m Y",
               minDate: "today",
               mode: "single",

               // Additional options can be added here
           });*/

    </script>


@endpush
