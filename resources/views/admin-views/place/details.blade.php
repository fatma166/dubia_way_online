@extends('layouts.admin.master')
@section('title')
    {{__("detail_place")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">تفاصيل   {{$data['place']['name']}} </h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-primary">
                                    <i class="dripicons-store font-24 avatar-title text-primary"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{$data['order_amounts']}}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">المبيعات</p>
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
                                    <i class="dripicons-store font-24 avatar-title text-success"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{$data['order_count']}}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">اجمالي الطلبات</p>
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
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">ر.س <span data-plugin="counterup">{{$data['withdraw'][0]->withdraw_amount}} </span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate"> المسحوب</p>
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
                                <div class="avatar-lg rounded bg-soft-warning">
                                    <i class="dripicons-store font-24 avatar-title text-warning"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">ر.س <span data-plugin="counterup">{{    ($data['withdraw'][0]->withdraw_amount)-($data['order_count']) }}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">المحفظة</p>
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
    </div>
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <!-- project card -->
            <div class="card d-block">
                <div class="card-body">
                    <div class="float-sm-end mb-2 mb-sm-0">
                        <div class="row g-2">
                            <div class="col-auto">
                                <a href="{{route('admin.place.index')}}" class="btn btn-sm btn-link">
                                    <i class="mdi mdi-keyboard-backspace"></i> الرجوع </a>
                            </div>
                            <div class="col-auto">
                                <select class="form-select form-select-sm form" id="change_place_status">
                                    <option  value="1" @if(($data['place']['status'])==1){{'selected'}}@endif>مفعل</option>
                                    <option value="0" @if(($data['place']['status'])==0){{'selected'}}@endif>غير مفعل</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- end dropdown-->
                    <h4 class="mb-3 mt-0 font-18"> {{$data['place']['name']}}</h4>
                    <div class="clerfix"></div>
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Ticket type -->
                            <label class="mt-2 mb-1">التقييم</label>
                            <p> {{$data['evaluation']['rating']}} <i class="mdi mdi-star text-warning"></i>
                            </p>
                            <!-- end Ticket Type -->
                        </div>
                        <div class="col-md-3">
                            <!-- Ticket type -->
                            <label class="mt-2 mb-1">التصنيف</label>
                            <p> {{$data['place']['compilation']->title}}</p>
                            <!-- end Ticket Type -->
                        </div>
                        <div class="col-md-3">
                            <!-- Ticket type -->
                            <label class="mt-2 mb-1">العنوان</label>
                            <p>{{$data['place']['address']}}</p>
                            <!-- end Ticket Type -->
                        </div>
                        <div class="col-md-3">
                            <!-- Ticket type -->
                            <label class="mt-2 mb-1">الوصف</label>
                            <p>{{$data['place']['footer_text']}} </p>
                            <!-- end Ticket Type -->
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Reported by -->
                            <label class="mt-2 mb-1">صاحب المكان :</label>
                            <div class="d-flex align-items-start">
                                <img src="{{asset($data['place']['logo'])}}"  class="rounded-circle me-2" height="24"  onerror="this.src='{{asset('assets/images/logo.png')}}'" />
                                <div class="w-100">
                                    <p> {{isset($data['place']->vendor->f_name)?$data['place']->vendor->f_name:""}}  {{isset($data['place']->vendor->l_name)?$data['place']->vendor->l_name:""}}</p>
                                </div>
                            </div>
                            <!-- end Reported by -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">رقم الهاتف :</label>
                            <div class="d-flex align-items-start">
                                <div class="w-100">
                                    <p>{{$data['place']->phone}}</p>
                                </div>
                            </div>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">ساعات العمل</label>
                            <div class="d-flex align-items-start">
                                <div class="w-100">
                                    <p> من الساعه {{$data['place']['opening_time']->format('H:i')}}الي الساعه {{$data['place']['closeing_time']->format('H:i')}}</p>
                                </div>
                            </div>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">رسوم التوصيل</label>
                            <div class="d-flex align-items-start">
                                <div class="w-100">
                                    <p>{{$data['place']['delivery_charge']}}</p>
                                </div>
                            </div>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">وقت التوصيل</label>
                            <p>خلال {{__($data['place']['delivery_time'])}} {{__($data['place']['delivery_time_unit'])}}</p>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">الحد الأدني للطلب</label>
                            <p> {{$data['place']['minimum_order']}} {{__(config('app.currency'))}}</p>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">البريد الإلكتروني</label>
                            <p>{{$data['place']->email}}</p>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-16 mb-3">جوجل ماب</h5>

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d0.1!2d{{$data['place']['longitude']}}!3d{{$data['place']['latitude']}}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z{{$data['place']['latitude']}}!5e0!3m2!1sen!2sus!4v1636471085612!5m2!1sen!2sus&markers={{$data['place']['latitude']}},{{$data['place']['longitude']}}"
                        width="300"
                        height="200"
                        style="border: 0"
                        allowfullscreen=""
                        loading="lazy"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <!-- container -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active"> الطلبات </a>
                    </li>
                    <li class="nav-item">
                        <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link"> المسحوبات </a>
                    </li>
                    <li class="nav-item">
                        <a href="#messages" data-bs-toggle="tab" aria-expanded="false" class="nav-link"> التقييمات </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- first tab -->
                    <div class="tab-pane show active" id="home">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap table-bordered" id="products-datatable">
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
                                                @if(count($data['orders'])>0)
                                                    @foreach(($data['orders']) as $order)

                                                        <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck{{$order->id}}">
                                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td> {{$order->id}} </td>
                                                        <td> {{$order->created_at}} </td>
                                                               <td> {{ isset($order->customer->f_name)? $order->customer->f_name:""}}  {{isset($order->customer->l_name)?$order->customer->l_name:""}} <br>@if(isset($order->customer->phone)) @endif </td>
                                                            <td class="table-user">
                                                            <img src="{{asset($data['place']['logo'])}}" alt="table-user" class="me-2 rounded-circle"  onerror="this.src='{{asset('assets/images/logo.png')}}'" >
                                                            <a href="javascript:void(0);" class="text-body fw-semibold">{{$data['place']['name']}}</a>
                                                        </td>
                                                         <td>{{$order->order_amount}} </td>
                                                        <td>
                                                                                                                      <span class="badge @if($order['order_status']=='pending') {{'bg-warning rounded-pill'}}@elseif($order['order_status']=='delivered'){{ 'bg-soft-success text-success' }}@elseif($order['order_status']=='processing'){{'bg-blue rounded-pill'}}@elseif($order['order_status']=='canceled') {{' bg-danger rounded-pill' }}@elseif ($order['order_status']=='picked_up'){{'bg-secondary text-light rounded-pill'}} @elseif ($order['order_status']=='confirmed'){{'bg-secondary text-light rounded-pill'}}@endif">{{$order['order_status']}}</span>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('admin.order.details',['id'=>$order['id']])}}" class="action-icon">
                                                                <i class="mdi mdi-eye"></i>
                                                            </a>
                                                        </td>
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
                                        @if(!request()->filled("print"))
                                            <div class="pagination pagination-rounded justify-content-end mb-0">
                                                {!! $data['orders']->withQueryString()->links() !!}
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
                    </div>
                    <!-- end tab -->
                    <div class="tab-pane" id="profile">
                        <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                            <thead>
                            <tr>
                                <th style="width: 20px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th>المبلغ</th>
                                <th>اسم صاحب الحساب</th>
                                <th>رقم الحساب</th>
                                <th>اسم البنك</th>
                                <th>فرع البنك</th>
                                <th>تاريخ الطلب</th>
                                <th>الحالة</th>
                                <th style="width: 85px;">الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($data['withdraw'])>0)
                            @foreach($data['withdraw'] as $withdraw)
                          @if($withdraw->count>0)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck{{$withdraw->id}}">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td>{{$withdraw->amount}}</td>
                                <td>@if(isset($withdraw->vendor)){{$withdraw->vendor->f_name?$withdraw->vendor->f_name:''}} {{$withdraw->vendor->l_name?$withdraw->vendor->l_name:''}}@endif</td>
                                <td>@if(isset($withdraw->vendor)){{$withdraw->vendor->account_no?$withdraw->vendor->account_no:''}} @endif</td>
                                <td>@if(isset($withdraw->vendor)){{$withdraw->vendor->bank_name?$withdraw->vendor->bank_name:''}} @endif</td>
                                <td>@if(isset($withdraw->vendor)){{$withdraw->vendor->branch?$withdraw->vendor->branch:''}} @endif</td>
                                <td> {{$withdraw->created_at}} </td>
                                <td>
                                    <span class="badge @if($withdraw->approved==0) bg-soft-warning text-warning @else bg-soft-success text-success @endif">@if($withdraw->approved==0)في الانتظار@elseتم التحويل @endif</span>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="action-icon">
                                        <i class="mdi mdi-checkbox-marked-circle"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="action-icon">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
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
                    <div class="tab-pane" id="messages">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap table-bordered" id="products-datatable">
                                                <thead>
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>التقييم</th>
                                                    <th>التعليق</th>
                                                    <th>رقم الطلب</th>
                                                    <th>تاريخ الطلب</th>
                                                    <th>بيانات العميل</th>
                                                    <th>صورة المنتج</th>
                                                    <th>الحالة</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($data['reviews'] )>0)
                                                @foreach($data['reviews'] as $review)
                                                    @if(isset($review->customer->f_name))
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck{{$review->id}}">
                                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td>{{$review->rating}}</td>
                                                        <td>{{$review->comment}}</td>
                                                        <td> {{$review->order_id}} </td>
                                                        <td> {{$review->created_at}} </td>
                                                        <td>{{$review->customer->f_name}}  {{$review->customer->l_name}}<br>{{$review->customer->phone}} </td>

                                                        <td class="table-user">
                                                            @if(isset($review->attachment))
                                                            <img src="{{asset($review->attachment)}}" alt="table-user" class="me-2 rounded-circle">
                                                             @endif
                                                        </td>
                                                        <td><span class="badge @if($review->status==1){{ 'bg-soft-success text-success' }}@else{{' bg-danger rounded-pill' }} @endif"> @if($review->status==1)مفعل@elseغير مفعل @endif</span></td>

                                                    </tr>

                                                    @endif
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
                                        @if(!request()->filled("print"))
                                            <div class="pagination pagination-rounded justify-content-end mb-0">
                                                {!! $data['reviews']->withQueryString()->links() !!}
                                            </div>
                                        @endif

                                    </div>
                                    <!-- end card-body-->
                                </div>
                                <!-- end card-->
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card-->
    </div>
    <!-- end col -->


@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {

        $('#change_place_status').on('change', function() {

            $.ajax({
                url: '{{route('admin.place.change-status')}}',
                method: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id: '{{$data['place']['id']}}',
                    status: this.value,
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
