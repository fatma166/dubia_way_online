@extends('layouts.admin.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">إنشاء كوبون</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.coupon.store')}}" method="post" id="banner_form"  enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="couponame" class="form-label">اسم الكوبون</label>
                                    <input type="text"  name="title" value="{{old('title')}}" id="couponame" class="form-control @error("title") is-invalid @endError" placeholder="ادخل هنا اسم الكوبون">
                                    @error("title")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="couponcode" class="form-label">نوع الكوبون</label>
                                    <select type="text"  name="coupon_type" class="form-control @error("coupon_type") is-invalid @endError" value="{{old('coupon_type')}}">

                                        <option value="default">{{__('default')}}</option>
                                        <option value="first_order">{{__('first_order')}}</option>
                                        <option value="free_delivery">{{__('free_delivery')}}</option>
                                    </select>
                                    @error("code")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="couponcode" class="form-label">كود الكوبون</label>
                                    <input type="text"  name="code" value="{{old('code')}}" id="couponcode" class="form-control @error("code") is-invalid @endError" placeholder="ادخل كود الكوبون كمثال #867575">
                                    @error("code")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">تاريخ بداية الكوبون</label>
                                    <input class="form-control @error("start_date") is-invalid @endError" name="start_date" value="{{old('start_date')}}" id="example-date" type="date" >
                                    @error("start_date")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="example-date" class="form-label">تاريخ نهاية الكوبون</label>
                                    <input class="form-control @error("expire_date") is-invalid @endError"  id="example-date" type="date" name="expire_date" value="{{old('expire_date')}}">
                                    @error("expire_date")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="couponcode" class="form-label">اقل قيمة للشراء للحصول علي الخصم</label>
                                    <input type="text" id="couponcode" class="form-control @error("min_purchase") is-invalid @endError" placeholder="ادخل القيمة"  name="min_purchase" value="{{old('min_purchase')}}">
                                    @error("min_purchase")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
                            <!-- end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="selectcat" class="form-label">اختر التصنيف</label>
                                    <select id="selectcat" name="compilation_id" class="form-control compilation @error("compilation_id") is-invalid @endError" name="compilation_id" data-toggle="select2" data-width="100%" >
                                        <option>اختر التصنيف</option>
                                        @foreach($compilations as $compilation)
                                            <option value="{{$compilation->id}}">{{$compilation->title}}</option>
                                        @endforeach
                                    </select>
                                    @error("compilation_id")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="selectplace" class="form-label">اختر المكان</label>
                                    <select id="selectplace" class="form-control @error("restaurant_id") is-invalid @endError" name="restaurant_id"  value="{{old('restaurant_id')}}" data-toggle="select2" data-width="100%">
                                        <option>كل الأماكن</option>
                                        @foreach($places as $place)
                                            <option value="{{$place->id}}">{{$place->name}}</option>
                                        @endforeach
                                    </select>
                                    @error("restaurant_id")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="selectmethod" class="form-label">طريقة حساب الخصم</label>
                                    <select id="selectmethod"  name="discount_type" value="{{old('discount_type')}}" class="form-control @error("discount_type") is-invalid @endError" data-toggle="select2" data-width="100%">
                                        <option value="	percentage	">%نسبة مئوية</option>
                                        <option value="fixed">مبلغ ثابت</option>
                                    </select>
                                    @error("discount_type")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="percent" class="form-label">ادخل النسبة</label>
                                    <input type="text"  name="discount"  value="{{old('discount')}}" id="percent" class="form-control @error("discount") is-invalid @endError" placeholder="ادخل النسبة كمثال :20">
                                    @error("discount")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card-body -->
                    <!-- cta -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary waves-effect waves-light m-1">
                                <i class="fe-check-circle me-1"></i> إنشاء </button>
                          <a href="{{ route('admin.coupon.index')}}" class="btn btn-light waves-effect waves-light m-1"> <i class="fe-x me-1"></i>إلغاء</a>

                        </div>
                    </div>
                    <!-- cta -->
                </div>
            </form>
            <!-- end card-->

        </div>
        <!-- end col-->
    </div>
    <!-- end row-->

@endsection
