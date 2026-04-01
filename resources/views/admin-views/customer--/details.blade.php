@extends('layouts.admin.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">تفاصيل { اسم المكان }</h4>
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
                                        <span data-plugin="counterup">{{$data['place']->order_count}}</span>
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
                                    <h3 class="text-dark mt-1">ر.س <span data-plugin="counterup">@php isset($data['wallet']->balance)? $data['wallet']->balance:0 @endphp</span>
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
                                <select class="form-select form-select-sm form">
                                    <option selected="1">مفعل</option>
                                    <option value="0">غير مفعل</option>

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
                                <img src="{{asset($data['place']['logo'])}}" alt="Arya S" class="rounded-circle me-2" height="24" />
                                <div class="w-100">
                                    <p> {{isset($data['place']['vendor']->f_name)?$data['place']['vendor']->f_name:""}}  {{isset($data['place']['vendor']->l_name)?$data['place']['vendor']->l_name:""}}</p>
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
                                    <p>{{$data['place']['phone']}}</p>
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
                                    <p> من الساعه {{$data['place']['opening_time']}}الي الساعه {{$data['place']['closeing_time']}}</p>
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
                            <p>خلال {{$data['place']['delivery_time']}} {{$data['place']['delivery_time_unit']}}</p>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">الحد الأدني للطلب</label>
                            <p>خلال {{$data['place']['delivery_time']}}</p>
                            <!-- end assignee -->
                        </div>
                        <!-- end col -->
                        <div class="col-md-3">
                            <!-- assignee -->
                            <label class="mt-2 mb-1">البريد الإلكتروني</label>
                            <p>{{$data['place']['email']}}</p>
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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d137{{$data['place']['longitude']}}!2d{{$data['place']['longitude']}}!3d{{$data['place']['latitude']}}!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f7d156b7aa9d7f%3A0x5e10374e6ea64147!2z2LTYsdmD2Kkg2KfYs9iq2KjYtNixIOKAkyDYqNix2YXYrNipINmI2KrYtdmF2YrZhSDZhdmI2KfZgti5INin2YTYp9mG2KrYsdmG2Kog2YjYp9mE2KzZiNin2YQ!5e0!3m2!1sen!2seg!4v1693614344769!5m2!1sen!2seg" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

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
                                                @foreach($data['order'])
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="customCheck{{$data['orders']->id}}">
                                                            <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td> {{$data['orders']->id}} </td>
                                                    <td> {{$data['orders']->created_at}} </td>
                                                    <td>{{$data['orders']->customer->f_name}}  {{$data['orders']->customer->l_name}}<br>{{$data['orders']->customer->phone}} </td>
                                                    <td class="table-user">
                                                        <img src="{{asset($data['place']['logo'])}}" alt="table-user" class="me-2 rounded-circle">
                                                        <a href="javascript:void(0);" class="text-body fw-semibold">{{$data['place']['name']}}</a>
                                                    </td>
                                                    <td> ٣٤٣٤ ريال </td>
                                                    <td>
                                                        <span class="badge @if($data['orders']->order_status=='delivered')bg-soft-success text-success@elseif($data['orders']->order_status=='picked_up')bg-secondary text-light rounded-pill@elseif($data['orders']->order_status=='processing') bg-blue rounded-pill @elseif($data['orders']->order_status=='pending')bg-warning rounded-pill @elseif($data['orders']->order_status=='canceled')bg-warning rounded-pill@endif">{{$data['orders']->order_status}}</span>
                                                    </td>
                                                    <td>
                                                        <a href="./order-detail.html" class="action-icon">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                 @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <ul class="pagination pagination-rounded justify-content-end mb-0">
                                            <li class="page-item">
                                                <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                    <span class="visually-hidden">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item active">
                                                <a class="page-link" href="javascript: void(0);">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript: void(0);">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript: void(0);">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript: void(0);">4</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript: void(0);">5</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                                    <span aria-hidden="true">»</span>
                                                    <span class="visually-hidden">Next</span>
                                                </a>
                                            </li>
                                        </ul>
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
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td>٤٣٤ ريال</td>
                                <td>محمد نصر</td>
                                <td>38646566556</td>
                                <td>بنك مصر</td>
                                <td>فرع بركة السبع</td>
                                <td> ٢٢ مارس ٢٠٢٣ </td>
                                <td>
                                    <span class="badge bg-soft-warning text-warning">في الانتظار</span>
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
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td>٤٣٤ ريال</td>
                                <td>محمد نصر</td>
                                <td>38646566556</td>
                                <td>بنك مصر</td>
                                <td>فرع بركة السبع</td>
                                <td> ٢٢ مارس ٢٠٢٣ </td>
                                <td>
                                    <span class="badge bg-soft-success text-success">تم التحويل</span>
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
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td>٤٣٤ ريال</td>
                                <td>محمد نصر</td>
                                <td>38646566556</td>
                                <td>بنك مصر</td>
                                <td>فرع بركة السبع</td>
                                <td> ٢٢ مارس ٢٠٢٣ </td>
                                <td>
                                    <span class="badge bg-soft-danger text-danger">ملغي</span>
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
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="messages"> هنا يعرض التقييمات </div>
                </div>
            </div>
        </div>
        <!-- end card-->
    </div>
    <!-- end col -->


@endsection
