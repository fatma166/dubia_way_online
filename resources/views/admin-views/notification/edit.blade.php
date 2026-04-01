@extends('layouts.admin.master')
@section('title')
    {{__("edit_notification")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">إرسال إشعار</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <form action="{{route('admin.notification.update',['notification'=>$record->id])}}" method="post" id="banner_form"   enctype="multipart/form-data">
            @csrf
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">اسم الشعار</label>
                                    <input type="text" name="title"  value="{{$record->title}}" class="form-control" placeholder="ادخل اسم الشعار المرسل">
                                    @error("title")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="project-overview" class="form-label">الإرسال إلي</label>
                                    <select  name="target" value={{$record->target}} class="form-control"  data-toggle="select2" data-width="100%">
                                        <option value="all" @if($record->target=="all") selected @endif >الكل</option>
                                        <option value="vendor" @if($record->target=="vendor") selected @endif >الأماكن</option>
                                        <option value="customer" @if($record->target=="customer") selected @endif >المشتريين</option>
                                    </select>
                                </div>
                    
                                <div class="mb-3">
                                    <label   for="project-overview" class="form-label">وصف الإشعار</label>
                                    <textarea class="form-control" name="description"  value="{{$record->description}}" rows="5" placeholder="ادخل هنا تفاصيل الاشعار">{{$record->description}}</textarea>
                                </div>
                            </div>
                            <!-- end col-->
                            <div class="col-xl-6">
                                <div class="mt-3">
                                    <div class="mt-3 logo_img_block">

                                        <input type="file" name="image[]" class="logo_img" data-plugins="dropify" data-max-file-size="1M" accept="image/*"  />

                                        <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة الإشعار بحجم لا يتعدي ال ١ ميجا</p>
                                        <input type="hidden" value="{{$record->image}}" name="old_image">
                                    </div>

                                    @error("image")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
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
<script src="{{asset('assets/libs/dropify/js/dropify.min.js')}}"></script>
    <script>

        var loadFile = function (event) {
            var output = document.getElementById('output');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src) // free memory
                };

            } else {
                output.src = '{{$record->image}}';
            }

        };

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


