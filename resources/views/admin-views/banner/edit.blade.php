@extends('layouts.admin.master')
@section('title')
    {{__("edit_banner")}}
@endsection

@section('content')

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">تعديل إعلانات</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form action="{{route('admin.banner.update', [$banner->id])}}" method="post" id="banner_form"   enctype="multipart/form-data">
                    @csrf
                <div class="card">

                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">إسم الإعلان</label>
                                    <input type="text"  value="{{ $banner->title }}" name="title"  class="form-control" placeholder="اكتب هنا اسم الإعلان">
                                </div>
                                <div class="mb-3">
                                    <label for="selectmethod" class="form-label">المنطقة</label>
                                    <select name="zone_id" id="zone" class="form-control js-select2-custom" onchange="getRequest('{{url('/')}}/admin/food/get-foods?zone_id='+this.value,'choice_item')">
                                        <option  disabled selected>---{{__('messages.select')}}---</option>

                                        @foreach($zones as $zone)

                                                <option value="{{$zone['id']}}" {{$zone->id == $banner->zone_id?'selected':''}}>{{$zone['name']}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label for="selectmethod" class="form-label">مكان الاعلان</label>
                                    <select name="module_place" class="form-control js-select2-custom" >
                                        <option value="homefirst" @if($banner->module_place=="homefirst") selected @endif>{{__('homefirst')}}</option>
                                         <option value="homefirst_mobile" @if($banner->module_place=="homefirst_mobile") selected @endif>{{__('homefirst_mobile')}}</option>

                                        <option value="homedown_discount" @if($banner->module_place=="homedown_discount") selected @endif >{{__('homedown_discount')}}</option>
                                        <option value="homedown_offers" @if($banner->module_place=="homedown_offers") selected @endif>{{__('homedown_offers')}}</option>
                                        <option value="inner_page" @if($banner->module_place=="inner_page") selected @endif >{{__('inner_page')}}</option>
                                    </select>
                                    @error("module_place")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <div class="mt-3 logo_img_block">

                                        <input type="file"  name="image[]" class="logo_img" data-plugins="dropify" data-max-file-size="4M" accept="image/*"  />

                                        @error("image[]")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                        <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة التصنيف بحجم لا يتعدي ال ١ ميجا</p>
                                        <input type="hidden" value="{{$banner->image}}" name="old_image">
                                    </div>
                                </div>
                            </div>
                            <!-- end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="selectcat" class="form-label">اختر التصنيف</label>
                                    <select id="selectcat" class="form-control" name="compilation_id" data-toggle="select2" data-width="100%">
                                        <option>اختر اسم التصنيف</option>
                                        @foreach($compilations as $compilation)

                                            <option value="{{$compilation->id}}" {{$compilation->id == $banner->compilation_id?'selected':''}}>{{$compilation->title}}</option>
                                         @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="selectplace" class="form-label">اختر المكان</label>
                                    <select id="selectplace" class="form-control" name="place_id" data-toggle="select2" data-width="100%">
                                        <option>اختر اسم المكان</option>
                                        @foreach($places as $place)
                                            <option value="{{$place['id']}}" {{$place->id == $banner->place_id?'selected':''}}>{{$place['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="selectmethod" class="form-label">اولوية الاعلان</label>
                                    <input type="number" name="priority"  value="{{$banner->priority}}" class="form-control js-select2-custom" />

                                    @error("priority")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
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
                </form>
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->

@endsection
@push('script')
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
                output.src = '{{$banner->image}}';
            }

        };

        /* logo*/
        $('.logo_img').dropify();
        $(".logo_img").addClass('dropify');
        $(".logo_img").attr("data-height", 300);
        $(".logo_img").attr("data-default-file", "{{asset($banner->image)}}");
        $(".logo_img_block .dropify-preview .dropify-render").html('<img src="{{asset($banner->image)}}"/>');

        $('.dropify').dropify();
        $('.logo_img_block .dropify-wrapper .dropify-preview').attr('style', 'display:block !important');




    </script>
@endpush
