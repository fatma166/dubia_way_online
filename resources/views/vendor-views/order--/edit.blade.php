@extends('layouts.admin.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">إتعديل صاحب مكان</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.place.update',['id'=>$record->id])}}" method="post" id="banner_form"  enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" value="{{$record->id}}">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <div class="mt-3 cover_img_block">
                                        <input type="file"   name="cover_photo[]"  data-plugins="dropify" data-max-file-size="1M"  class="cover_dropfy @error("cover_photo") is-invalid @endError"  onchange="SubmitForm($(this));"/>
                                        <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة الكوفر بحجم لا يتعدي ال ١ ميجا</p>

                                        @error("image[]")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="projectname" class="form-label ">اسم المكان</label>
                                    <input type="text"   name="name" value="{{$record->name}}" id="projectname" class="form-control  @error("name") is-invalid @endError" placeholder="اكتب هنا اسم المكان">
                                    @error("name")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>

                                <div class="mb-3">
                                    <label for="project-overview" class="form-label">وصف المكان</label>
                                    <textarea class="form-control   @error("footer_text") is-invalid @endError" name="footer_text"    id="project-overview" rows="5" placeholder="اكتب هنا وصف بسيط عن المكان">{{$record->footer_text}} </textarea>
                                    @error("footer_text")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">عنوان المكان</label>
                                    <input type="text" name="address"  value="{{$record->address}}" id="projectname" class="form-control  @error("address") is-invalid @endError" placeholder="اكتب هنا العنوان بالتفصيل">
                                    @error("address")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">ثمن التوصيل</label>
                                    <input type="text" name="delivery_charge"  value="{{$record->delivery_charge}}" id="projectname" class="form-control  @error("delivery_charge") is-invalid @endError" placeholder="كمثال :٣٤">
                                    @error("delivery_charge")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">الحد الأدني للطلب</label>
                                    <input type="text" name="minimum_order"  value="{{$record->minimum_order}}" id="projectname" class="form-control @error("minimum_order") is-invalid @endError" placeholder="كمثال :٣٤">
                                    @error("minimum_order")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
                            <!-- end col-->
                            <div class="col-xl-6">
                                <div class="mb-3 logo_img_block">
                                    <div class="mt-3">
                                        <input type="file"  name="image[]" class="logo_img" data-plugins="dropify" data-max-file-size="1M" />
                                        <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل اللوجو بحجم لا يتعدي ال ١ ميجا</p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="project-overview" class="form-label">اختر التصنيف</label>
                                    <select class="form-control  @error("compilation_id") is-invalid @endError" name="compilation_id" data-toggle="select2" data-width="100%">
                                        <option>اختر التصنيف</option>
                                        @foreach($compilations as $compile)
                                            <option value="{{$compile->id}}" @if ($record->compilation_id==$compile->id) selected @endif>{{$compile->title}}</option>
                                        @endforeach
                                    </select>
                                    @error("compilation_id")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="row">
                                    <h5>مواعيد العمل </h5>
                                    <div class="mb-3 col">
                                        <label for="example-time" class="form-label">من:</label>
                                        <input class="form-control @error("opening_time") is-invalid @endError" id="example-time" type="time" name="opening_time" value="{{date("H:i:s",strtotime($record->opening_time))}}" >
                                        @error("opening_time")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="example-time" class="form-label">إلي:</label>
                                        <input type="time" name="closeing_time" value="{{date("H:i:s",strtotime($record->closing_time))}}" class="form-control  @error("closing_time") is-invalid @endError" id="example-time"  >
                                        @error("closeing_time")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row">
                                    @php
                                   $delivery_time= explode('-',($record->delivery_time));
                                    $delivery_time_from=$delivery_time[0]??0;
                                   $delivery_time_to=$delivery_time[1]??0;
                                    @endphp
                                    <h5>التوصيل في خلال : </h5>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="projectname" class="form-label">من :</label>
                                            <input type="text" name="delivery_time_from"  value="{{$delivery_time_from}}" id="projectname" class="form-control @error("delivery_time_from") is-invalid @endError"  >
                                            @error("delivery_time_from")
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="projectname" class="form-label">إلي</label>
                                            <input type="text" id="projectname" class="form-control  @error("delivery_time_to") is-invalid @endError" name="delivery_time_to"  value="{{$delivery_time_to}}" placeholder="كمثال : ٦٠">
                                            @error("delivery_time_to")
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="project-overview" class="form-label">الوقت</label>
                                            <select class="form-control  @error("delivery_time_unit") is-invalid @endError" name="delivery_time_unit"  value="{{$record->delivery_time_unit}}"data-toggle="select2" data-width="100%">
                                                <option value="minutes">دقائق</option>
                                                <option value="hours">ساعات</option>
                                            </select>
                                            @error("delivery_time_unit")
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
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

                <!-- start card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="project-overview" class="form-label">المنطقة</label>
                                    <select class="form-control  @error("zone_id") is-invalid @endError"  name="zone_id" data-toggle="select2" data-width="100%">
                                        <option>المنطقة</option>
                                        @foreach($zones as $zone)
                                            <option value="{{$zone->id}}" @if($record->zone_id==$zone->id)selected @endif>{{$zone->name}}</option>
                                        @endforeach
                                    </select>
                                    @error("zone_id")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">خط العرض</label>
                                    <input type="text" id="projectname"  name="latitude" class="form-control  @error("latitude") is-invalid @endError"   value="{{$record->latitude}}" placeholder="اكتب هنا خط العرض">
                                    @error("latitude")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="mb-3">
                                    <label for="projectname" class="form-label">خط الطول</label>
                                    <input type="text" id="projectname" name="longitude" class="form-control  @error("longitude") is-invalid @endError" value="{{$record->longitude}}" placeholder="اكتب هنا خط الطول">
                                    @error("longitude")
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
                            <!-- end col-->
                            <div class="col-xl-6">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13731.377060846768!2d31.0780203!3d30.6383463!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f7d156b7aa9d7f%3A0x5e10374e6ea64147!2z2LTYsdmD2Kkg2KfYs9iq2KjYtNixIOKAkyDYqNix2YXYrNipINmI2KrYtdmF2YrZhSDZhdmI2KfZgti5INin2YTYp9mG2KrYsdmG2Kog2YjYp9mE2KzZiNin2YQ!5e0!3m2!1sen!2seg!4v1693614344769!5m2!1sen!2seg" width="500" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
                <!-- end card -->
                <!-- start card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <input type="hidden" name="vendor_id" value="{{$record->vendor->id}}">
                                    <div class="mb-3 col">
                                        <label for="projectname" class="form-label">الإسم الاول</label>
                                        <input type="text" id="projectname"  name="f_name" class="form-control @error("f_name") is-invalid @endError" value="{{$record->vendor->f_name}}" placeholder="اكتب هنا الاسم الاول">
                                        @error("f_name")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="projectname" class="form-label">الاسم الثاني</label>
                                        <input type="text" id="projectname" name="l_name"  value="{{$record->vendor->l_name}}"class="form-control @error("l_name") is-invalid @endError" placeholder="اكتب هنا الاسم الثاني">
                                        @error("l_name")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="projectname" class="form-label">رقم الهاتف</label>
                                        <input type="text" id="projectname"  name="phone" value="{{$record->vendor->phone}}"class="form-control @error("phone") is-invalid @endError" placeholder="اكتب هنا رقم الهاتف">
                                        @error("phone")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
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
                <!-- end card -->
                <!-- start card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="mb-3 col">
                                        <label for="projectname" class="form-label">البريد الالكتروني</label>
                                        <input type="text" id="projectname" name="email" value="{{$record->vendor->email}}" class="form-control @error("email") is-invalid @endError" placeholder="اكتب هنا الاسم الاول">
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="projectname" class="form-label">كلمة المرور</label>
                                        <input type="password" id="projectname"  name="password" password="password" class="form-control @error("password") is-invalid @endError" placeholder="********">
                                    </div>
                                    <div class="mb-3 col">
                                        <label for="projectname" class="form-label">تأكيد كلمة المرور</label>
                                        <input type="password" id="projectname" name="confirm_password" class="form-control @error("confirm_password") is-invalid @endError" placeholder="********">
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
                <!-- end card -->
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
@section('script')
    <script>
        /*cover */
        $('.cover_dropfy').dropify();
        $(".cover_dropfy").addClass('dropify');
        $(".cover_dropfy").attr("data-height", 300);
        $(".cover_dropfy").attr("data-default-file", "{{asset($record->cover_photo)}}");
        $(".cover_img_block .dropify-preview .dropify-render").html('<img src="{{asset($record->cover_photo)}}"/>');

        $('.dropify').dropify();
         $('.dropify-wrapper .dropify-preview').attr('style', 'display:block !important');

         /* logo*/
        $('.logo_img').dropify();
        $(".logo_img").addClass('dropify');
        $(".logo_img").attr("data-height", 300);
        $(".logo_img").attr("data-default-file", "{{asset($record->cover_photo)}}");
        $(".logo_img_block .dropify-preview .dropify-render").html('<img src="{{asset($record->logo)}}"/>');

        $('.dropify').dropify();
        $('.logo_img_block .dropify-wrapper .dropify-preview').attr('style', 'display:block !important');




        $(document).ready(function() {

             /*   function resetPreview(name, src, fname = '') {
                    let input = $('input[name="' + name + '"]');
                    let wrapper = input.closest('.dropify-wrapper');
                    let preview = wrapper.find('.dropify-preview');
                    let filename = wrapper.find('.dropify-filename-inner');
                    let render = wrapper.find('.dropify-render').html('');

                    input.val('').attr('title', fname);
                    wrapper.removeClass('has-error').addClass('has-preview');
                    filename.html(fname);

                    render.append($('<img />').attr('src', src).css('max-height', input.data('height') || ''));
                    preview.fadeIn();
                }*/
            });

    </script>
@endsection
