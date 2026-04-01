@extends('layouts.admin.master')
@section('title')
    {{__("create_admin_employee")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">تعديل اعدادات</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <form action="{{route('admin.business_setting.update',['id'=>$record->id])}}" method="post"   enctype="multipart/form-data">
            @csrf
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">اسم الاعداد</label>
                                    <input type="text" id="projectname" name="key"  value="{{$record->key}}" class="form-control" placeholder="ادخل هنا اسم الاعداد">
                                    @error("key")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>

                                <div class="mb-3">
                                    <label for="projectname" class="form-label">القيمه</label>
                                    <input type="text" id="projectname" name="value"  value="{{$record->value}}" class="form-control" placeholder="القيمه">
                                    @error("value")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>

                            </div>
                            <!-- end col-->
                            <div class="col-lg-6"></div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
                <!-- cta -->
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-1">
                            <i class="fe-check-circle me-1"></i> إنشاء  </button>
                        <button type="button" class="btn btn-light waves-effect waves-light m-1">
                            <i class="fe-x me-1"></i> إلغاء </button>
                    </div>
                </div>
                <!-- cta -->
            </div>

            <!-- end col-->
        </form>
    </div>
    <!-- end row-->


@endsection


