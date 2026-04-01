@extends('layouts.admin.master')
@section('title')
    {{__("create_banner")}}
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
            <form action="{{route('admin.banner.store')}}" method="post" id="banner_form"   enctype="multipart/form-data">
                @csrf
                <div class="card">

                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">إسم الإعلان</label>
                                    <input type="text"   name="title"  class="form-control" placeholder="اكتب هنا اسم الإعلان">
                                    @error("title")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="selectmethod" class="form-label">المنطقة</label>
                                    <select name="zone_id" id="zone" class="form-control js-select2-custom" onchange="getRequest('{{url('/')}}/admin/food/get-foods?zone_id='+this.value,'choice_item')">
                                        <option  disabled selected>{{__('select')}}</option>

                                        @foreach($zones as $zone)

                                            <option value="{{$zone['id']}}" >{{$zone['name']}}</option>
                                        @endforeach
                                    </select>
                                    @error("zone_id")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="selectmethod" class="form-label">مكان الاعلان</label>
                                    <select name="module_place" class="form-control js-select2-custom" >
                                        <option value="homefirst" >{{__('homefirst')}}</option>
                                        <option value="homefirst_mobile" >{{__('homefirst_mobile')}}</option>
                                        <option value="homedown_discount" >{{__('homedown_discount')}}</option>
                                        <option value="homedown_offers" >{{__('homedown_offers')}}</option>
                                        <option value="inner_page" >{{__('inner_page')}}</option>
                                    </select>
                                    @error("module_place")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>

                                <div class="mb-3">
                                    <div class="mb-3">

                                        <div class="mt-3 logo_img_block">

                                            <input type="file"  name="image[]" class="logo_img" data-plugins="dropify" data-max-file-size="4M" accept="image/*"  />

                                            <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة التصنيف بحجم لا يتعدي ال ١ ميجا</p>
                                        </div>

                                        @error("image")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
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

                                            <option value="{{$compilation->id}}" >{{$compilation->title}}</option>
                                        @endforeach
                                    </select>
                                    @error("compilation_id")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="selectplace" class="form-label">اختر المكان</label>
                                    <select id="selectplace" class="form-control" name="place_id" data-toggle="select2" data-width="100%">
                                        <option>اختر اسم المكان</option>
                                        @foreach($places as $place)

                                            <option value="{{$place['id']}}" >{{$place['name']}}</option>
                                        @endforeach
                                    </select>
                                    @error("place_id")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>

                                <div class="mb-3">
                                    <label for="selectmethod" class="form-label">اولوية الاعلان</label>
                                    <input type="number" name="priority"  class="form-control js-select2-custom" />

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
    @endpush

