@extends('layouts.admin.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">إنشاء عرض</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.offer.store')}}" method="post" id="banner_form"  enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="couponame" class="form-label">اسم العرض</label>
                                    <input type="text"  name="type" value="{{old('type')}}" id="couponame" class="form-control @error("type") is-invalid @endError" placeholder="ادخل هنا اسم العرض">
                                    @error("type")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                
                        <div class="mb-3 status_">
                            <label class="mb-2">الحالة <span class="text-danger">*</span></label>
                            <br/>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="is_active" value="1" id="inlineRadio1"  value="{{old("is_active")}}">
                                    <label class="form-check-label" for="inlineRadio1">منشور</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="is_active" value="0" id="inlineRadio2"  value="{{old("is_active")}}">
                                    <label class="form-check-label" for="inlineRadio2">مسودة</label>
                                </div>

                            </div>
                        </div>

                                
                            </div>
                            <!-- end col-->
                            <div class="col-lg-6">
                                
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
                                
                            </div>
                        </div>
                        <!-- end row -->
                    </div>

                    <!-- end card-body -->
                
                   <div class="mb-3 category_id_">
                        <label for="product-category" class="form-label">اختر القسم <span class="text-danger">*</span></label>
                        <select name="category_id"    value="{{old("category_id")}}"  class="form-control select2 @error("category_id") is-invalid @endError " id="product-category">
                            <option value="all">اختر</option>

                            <optgroup label="Shopping">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </optgroup>

                        </select>
                        @error("category_id")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>
                    <!-- cta -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary waves-effect waves-light m-1">
                                <i class="fe-check-circle me-1"></i> إنشاء </button>
                          <a href="{{ route('admin.offer.index')}}" class="btn btn-light waves-effect waves-light m-1"> <i class="fe-x me-1"></i>إلغاء</a>

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
