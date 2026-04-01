@extends('layouts.vendor.master')
@section('title')
    {{__("edit category")}}
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
            <form action="{{route('vendor.category.update',['id'=>$record->id])}}" method="post" id="banner_form"   enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">اسم التصنيف</label>
                                    <input type="text" name="name" value="{{$record->name}}" id="projectname" class="form-control @error("name") is-invalid @endError" placeholder="اكتب هنا اسم التصنيف">

                                    @error("name")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>

                            </div>
                            <!-- end col-->
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <div class="mt-3 logo_img_block">

                                        <input type="file"  name="image[]" class="logo_img" data-plugins="dropify" data-max-file-size="1M" accept="image/*"  />

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
                            <i class="fe-check-circle me-1"></i> تعديل</button>
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
