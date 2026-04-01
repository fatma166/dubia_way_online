@extends('layouts.vendor.master')
@section('title')
    {{__("add category")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">إضافة تصنيف</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <form action="{{route('vendor.category.store')}}" method="post" id="banner_form"   enctype="multipart/form-data">
                @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label for="projectname" class="form-label">اسم التصنيف</label>
                                <input type="text"  value="{{old("name")}}" name="name" id="projectname" class="form-control @error("name") is-invalid @endError" placeholder="اكتب هنا اسم التصنيف">
                                @error("name")
                                <span class="text-danger">{{ $message }}</span>
                                @endError

                            </div>

                        </div>
                        <!-- end col-->
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <div class="mt-3">
                                    <input type="file" name="image[]" data-plugins="dropify" data-max-file-size="1M" accept="image/*"
                                           class=" @error("image") is-invalid @endError"   />
                                    @error("image[]")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                    <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة التصنيف بحجم لا يتعدي ال ١ ميجا</p>
                                </div>
                            </div>
                        </div>
                        <!-- end col-->
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
                        <i class="fe-check-circle me-1"></i> إنشاء </button>

                    <a href="{{ route('vendor.category.index')}}" class="btn btn-light waves-effect waves-light m-1"> <i class="fe-x me-1"></i>إلغاء</a>
                </div>
            </div>
            <!-- cta -->
            </form>
        </div>
        <!-- end col-->
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
