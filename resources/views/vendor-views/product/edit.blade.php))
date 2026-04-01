@extends('layouts.vendor.master')
@section('title')
    {{__("edit product")}}
@endsection
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
@endpush

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">تعديل منتج</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <form action="{{route('vendor.product.update',['id'=>$record->id])}}" method="post"  enctype="multipart/form-data">
        @csrf
<div class="form_edit">

    <div class="row">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">بيانات المنتج</h5>

                    <div class="mb-3 name_">
                        <label for="product-name" class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                        <input  name="name"  value="{{$record->name}}" type="text" id="product-name" class="form-control @error("name") is-invalid @endError" placeholder="كمثال :  منتج الفلاني">
                        @error("name")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>



                    <div class="mb-3 description_">
                        <input type="hidden" name="id" value="{{$record->id}}">
                        <label for="product-description" class="form-label">وصف المنتج <span class="text-danger">*</span></label>
                        <input name="description" type="hidden">
                        <div id="snow-editor" style="height: 150px;"  name="description">{!! $record->description !!}</div> <!-- end Snow-editor-->
                        @error("description")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="mb-3 summary_">
                        <label for="product-summary" class="form-label">ملخص الوصف</label>
                        <textarea name="summary" class="form-control @error("summary") is-invalid @endError " id="product-summary" rows="3" placeholder="ادخل ملخص المنتج">{{$record->summary}}</textarea>
                        @error("summary")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="mb-3 category_id_">
                        <label for="product-category" class="form-label">اختر القسم <span class="text-danger">*</span></label>
                        <select name="category_id"  class="form-control select2 @error("category_id") is-invalid @endError " id="product-category">
                            <option value="all">اختر</option>

                            <optgroup label="Shopping">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($record->category_id==$category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </optgroup>

                        </select>
                        @error("category_id")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="mb-3 price_">
                        <label for="product-price">السعر الإفتراضي<span class="text-danger">*</span></label>
                        <input type="text" name="price" value="{{$record->price}}" class="form-control @error("price") is-invalid @endError " id="product-price" placeholder="ادخل السعر">
                        @error("price")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="mb-3 discount_">
                        <label for="product-discount"> الخصم<span class="text-danger"></span></label>
                        <input type="text" name="discount" value="{{$record->discount}}" class="form-control @error("discount") is-invalid @endError" id="product-price" placeholder="ادخل الخصم">
                        @error("discount")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>
                    <div class="mb-3 discount_type_">
                        <label for="product-price">نوع الخصم<span class="text-danger"></span></label>

                        <select name="discount_type"  class="form-control select2 @error("discount_type") is-invalid @endError " id="product-discount_type">
                            <option value="percent" @if($record->discount_type=='percent')  selected @endif>نسبه</option>
                            <option value="fixed" @if($record->discount_type=='fixed')  selected @endif>مبلغ</option>

                        </select>
                        @error("discount_type")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="mb-3 product_quantity_">
                        <label for="product-price">عدد المخزون<span class="text-danger"></span></label>
                        <input type="number"  name="product_quantity"  value="{{$record->product_quantity}}" class="form-control @error("product_quantity") is-invalid @endError" id="product-product_quantity" placeholder="كمثال ٣٤">
                        @error("product_quantity")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                    </div>

                    <div class="mb-3 status_">
                        <label class="mb-2">الحالة <span class="text-danger">*</span></label>
                        <br/>
                        <div class="d-flex flex-wrap">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="status" value="1" id="inlineRadio1" @if($record->status==1)checked @endif>
                                <label class="form-check-label" for="inlineRadio1">منشور</label>
                            </div>
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="status" value="0" id="inlineRadio2" @if($record->status==0)checked @endif>
                                <label class="form-check-label" for="inlineRadio2">مسودة</label>
                            </div>

                        </div>
                    </div>


                </div>
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-6">

            <div class="card ">
                <div class="card-body">
                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">صورة المنتج</h5>
                    <div class="mt-3 logo_img_block image_">
                        @error("image")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                        <input type="file"  name="image"  id="file-input6"  class="logo_img" data-plugins="dropify" data-max-file-size="1M" accept="image/*"   />


                        <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة التصنيف بحجم لا يتعدي ال ١ ميجا</p>
                        <input type="hidden" name="old_image" value=value="{{$record->image}}" />
                    </div>
                    <div class="mb-3">
                        <div class="form-group">

                            <div class="needsclick  dropzone" id="document-dropzone" >

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->



        </div> <!-- end col-->
    </div>
    <!-- end row -->



    <div class="row">
        <div class="col-12">
            <div class="text-center mb-3">
                <a href="{{ route('vendor.product.index')}}" class="btn w-sm btn-light waves-effect"> <i class="fe-x me-1"></i>إلغاء</a>
                <button type="submit" class="btn w-sm btn-success waves-effect waves-light submit_edit">إضافم المنتج</button>
                <a href="{{ route('vendor.product.delete',['id'=>$record->id])}}" class="btn w-sm btn-danger waves-effect waves-light"> حذف</a>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>
    </form>


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
@push('script')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>

        var uploadedDocumentMap = {}
        var name = ''
        Dropzone.options.documentDropzone = {
            url: "{{route('vendor.product.upload_images')}}",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            dictRemoveFile: "{{__('remove_file')}}",
            dictDefaultMessage:"  <i class=\"h1 text-muted dripicons-cloud-upload\"></i>\n" +
                "                                <h3>قم بادراج صور السلايدر.</h3>",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                name=response.name;
                $('form').append('<input type="hidden" name="file[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()

                console.log(file);
                if (typeof file.name!== 'undefined') {
                    name = file.name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                alert(name);
                $.ajax({
                    url: "{{route('vendor.product.delete-image')}}",
                    type: 'DELETE',
                    data: {image:name,id:"{{$record->id}}"},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        $('form').find('input[name="file[]"][value="' + name + '"]').remove()
                    }
                });

            },
            init: function () {
                    @if(isset($record) && $record->slider)
                var files =
                {!! json_encode( $record->slider) !!}
                    for (var i in files) {
                    var file = files[i]
                  //  $('form').append('<input type="hidden" name="file[]" value="' + file.image_path + '">')
                    console.log(file.image_path);
                    var mockFile = { name: file.image_path, size: 12345, type: 'image/*' };
                    this.options.addedfile.call(this, mockFile);
                    var APP_URL = {!! json_encode(url('/')) !!}
                    this.options.thumbnail.call(this, mockFile,APP_URL+"/"+file.image_path);
                   // this.options.addedfile.call(this,file)
                    file.previewElement.classList.add('dz-complete')

                }
                @endif
            }
        }
        $('.form_edit .submit_edit').click(function() {
            var myEditor = document.querySelector('#snow-editor')
            description1 = myEditor.children[0].innerHTML
            $("input[name=description]").val(description1);
        });


    </script>
@endpush

