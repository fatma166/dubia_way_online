@extends('layouts.admin.master')
@section('title')
    {{__("edit_compilation")}}
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
            <form action="{{route('admin.compilation.update',['id'=>$record->id])}}" method="post" id="banner_form"   enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">اسم التصنيف</label>
                                    <input type="text" name="title" value="{{$record->title}}" id="projectname" class="form-control @error("title") is-invalid @endError" placeholder="اكتب هنا اسم التصنيف">

                                    @error("title")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="project-overview" class="form-label">وصف التصنيف</label>
                                    <textarea class="form-control @error("description") is-invalid @endError"  name="description" value="{{$record->description}}"d="project-overview" rows="5" placeholder="اكتب هنا وصف التصنيف">{{$record->description}}</textarea>

                                    @error("description")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
                            <!-- end col-->
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <div class="mt-3 logo_img_block">

                                        <input type="file"  name="image[]" class="logo_img" data-plugins="dropify" data-max-file-size="1M" accept="image/*" />

                                        @error("image[]")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                        <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة التصنيف بحجم لا يتعدي ال ١ ميجا</p>
                                        <input type="hidden" value="{{$record->image}}" name="old_image">
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
                            <i class="fe-check-circle me-1"></i> تعديل</button>
                        <button type="button" class="btn btn-light waves-effect waves-light m-1">
                            <i class="fe-x me-1"></i> إلغاء </button>
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
<script src="{{asset('assets/libs/dropify/js/dropify.min.js')}}"></script>
    <script>

        /* logo*/
        $('.logo_img').dropify();
        $(".logo_img").addClass('dropify');
        $(".logo_img").attr("data-height", 300);
        $(".logo_img").attr("data-default-file", "{{asset($record->image)}}");
        $(".logo_img_block .dropify-preview .dropify-render").html('<img src="{{asset($record->image)}}"/>');

        $('.dropify').dropify();
        $('.logo_img_block .dropify-wrapper .dropify-preview').attr('style', 'display:block !important');




    </script>
@endsection
