@extends('layouts.vendor.master')
@section('title')
    {{__("edit_vendor_employee")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">تعديل بيانات مدير</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <form action="{{route('vendor.employee.update',['id'=>$record->id])}}" method="post"   enctype="multipart/form-data">
            @csrf
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">اسم المدير</label>
                                    <input type="text" id="projectname" name="f_name" class="form-control" value="{{$record->f_name}}" placeholder="ادخل هنا اسم المدير">
                                    @error("f_name")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>

                                <div class="mb-3">
                                    <label for="projectname" class="form-label">البريد الإلكتروني</label>
                                    <input type="text" id="projectname" name="email" class="form-control"  value="{{$record->email}}" placeholder="ادخل البريد الإلكتروني">
                                    @error("email")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">كلمة المرور</label>
                                    <input type="password" name="password" id="projectname"  class="form-control" placeholder="ادخل كلمة المرور">
                                    @error("password")
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
                            <i class="fe-check-circle me-1"></i> إنشاء مدير </button>
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
@section('script')


    <script>


        var loadFile = function (event) {
            var output = document.getElementById('output');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src) // free memory
                };

            } else {
                output.src = '';
            }

        };


    </script>
@endsection

