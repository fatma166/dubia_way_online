@extends('layouts.vendor.master')
@section('title')
    {{__("index")}}
@endsection

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
                        <div id="snow-editor" style="height: 150px;"></div> <!-- end Snow-editor-->
                    </div>

                    <div class="mb-3 summary_">
                        <label for="product-summary" class="form-label">ملخص الوصف</label>
                        <textarea name="summary" class="form-control @error("description") is-invalid @endError " id="product-summary" rows="3" placeholder="ادخل ملخص المنتج">{{$record->summary}}</textarea>
                        @error("description")
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
                        <input type="text" name="discount" value="{{$record->discount}}" class="form-control @error("discount") is-invalid @endError" id="product-price" placeholder="ادخل السعر بعد الخصم">
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

                        <input type="file"  name="image"  id="file-input6"  class="logo_img" data-plugins="dropify" data-max-file-size="1M" accept="image/*"  />

                        @error("image[]")
                        <span class="text-danger">{{ $message }}</span>
                        @endError
                        <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة التصنيف بحجم لا يتعدي ال ١ ميجا</p>
                    </div>

                    <form action="{{route('vendor.product.upload_images')}}" method="post" class="dropzone" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews"
                          data-upload-preview-template="#uploadPreviewTemplate">
                        @csrf
                        <div class="fallback">
                            <input name="file[]"  class="slider_images"type="file" multiple />
                        </div>

                        <div class="dz-message needsclick" >
                            <i class="h1 text-muted dripicons-cloud-upload"></i>
                            <h3>قم بادراج صور السلايدر.</h3>

                        </div>
                    </form>
                    <!-- Preview -->
                    <div class="dropzone-previews mt-3" id="file-previews">

                    </div>
                </div>
            </div> <!-- end col-->



        </div> <!-- end col-->
    </div>
    <!-- end row -->



    <div class="row">
        <div class="col-12">
            <div class="text-center mb-3">
                <button type="button" class="btn w-sm btn-light waves-effect">إلغاء</button>
                <button type="button" class="btn w-sm btn-success waves-effect waves-light submit_edit">إضافم المنتج</button>
                <button type="button" class="btn w-sm btn-danger waves-effect waves-light">حذف</button>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>

    <!-- file preview template -->
    <div class="d-none" id="uploadPreviewTemplate">
        <div class="card mt-1 mb-0 shadow-none border">
            <div class="p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                    </div>
                    <div class="col ps-0">
                        <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                        <p class="mb-0" data-dz-size></p>
                    </div>
                    <div class="col-auto">
                        <!-- Button -->
                        <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                            <i class="dripicons-cross"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="{{asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/js/dropify.min.js')}}"></script>
    <script>
        var formData;
        /*Dropzone.options.myAwesomeDropzone = {
            success: function (file, response) {
                alert("dsdfdfd");
                console.log(response.message);
                console.log(response.files);
            }
        }*/

        $(document).ready(function() {


            /* logo*/
            $('#file-input6').addClass('dropify');
            $('#file-input6').dropify();
            $('#file-input6').addClass('dropify');
            $('#file-input6').attr("data-height", 300);
            $('#file-input6').attr("data-default-file", "{{asset($record->image)}}");
            $(".logo_img_block .dropify-preview .dropify-render").html('<img src="{{asset($record->image)}}"/>');

            $('.dropify').dropify();
            $('.logo_img_block .dropify-wrapper .dropify-preview').attr('style', 'display:block !important');

            formData = new FormData();
            var fileInput = $('#file-input6'); // Replace 'file-input' with the ID of your file input element
            $old_image= '{{$record->image}}';
            formData.append('image', $old_image);
            fileInput.change(function () {
                var file = fileInput[0].files[0];
             //   alert(file);

                formData.append('image', file);
            });



            /*   multi image delete case*/
            $('a[data-dz-remove]').on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                var imageId = $(this).parent().find(".dz-filename > span").text();
alert(imageId);
                $.ajax({
                    url: "Your url here",
                    data: { imageId: imageId},
                    type: 'POST',
                    success: function (data) {
                        if (data.NotificationType === "Error") {
                            toastr.error(data.Message);
                        } else {
                            toastr.success(data.Message);
                        }},
                    error: function (data) {
                        toastr.error(data.Message);
                    }
                })

            });

        });
        $(document).ready(function() {
            // Initialize Dropzone
            Dropzone.options.myAwesomeDropzone = {

                url: "{{ route('vendor.product.upload_images') }}",
                paramName: "file",
                maxFilesize: 2, // Maximum file size in MB
                addRemoveLinks: true,
                success: function(file, response) {

                    console.log('File uploaded successfully');
                    // Perform any actions on successful upload
                }
            };
        });

        $('.form_edit .submit_edit').click(function() {
            var myEditor = document.querySelector('#snow-editor')
             description1= myEditor.children[0].innerHTML

            id='{{$record->id}}';
           name= $('input[name="name"]').val();

            summary=$('textarea[name="summary"]').val();
            category_id=$('select[name="category_id"]').val();
            price=$('input[name="price"]').val();
            discount= $('input[name="discount"]').val();
            product_quantity= $('input[name="product_quantity"]').val();
            status=$('input[name="status"]').val();
         //  image=formData;//$('.logo_img').val();

//            alert($('input[name="category_id"]').val());
            url="{{route('vendor.product.update',['id'=>$record->id])}}";

            formData.append('id', id);
            formData.append('name', name);
            formData.append('description', description1);
            formData.append('summary', summary);
            formData.append('category_id', category_id);
            formData.append('price', price);
            formData.append('discount', discount);
            formData.append('product_quantity', product_quantity);
            formData.append('status', status);

           /* var data= {id:id,name:name,
                description:description1,
                summary:summary,
                category_id:category_id,
                price: price,
                discount:discount,
                product_quantity:product_quantity,
                status:status,
                image:image ,
            };*/
            console.log(url);
            $.ajax({
                url:url,
                type:'POST',
                data:formData,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                processData: false,
               contentType: false,
                success: function(data) {
                    $('.text-danger').empty();
                    $('is-invalid').removeClass();

                   // if(data.hasOwnProperty('success')){

                    var routeUrl = "{{ route('vendor.product.index') }}";
                    window.location.href = routeUrl;
                       // location.reload(true);
                   // }else{
                       // alert("error");
                     //   console.log(data.error.errors);
                       //   printErrorMsg(data.error.errors);
                   // }
                },
                error :function( data ) {
                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            console.log(key + " " + value);
                            $('#response').addClass("alert alert-danger");

                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    console.log(key + " " + value);
                                    $('.'+key+'_').append('<span class="text-danger">'+value+'</span>');
                                    $('input[name="'+key+'"]').addClass('is-invalid');
                                  //  $('#response').show().append(value + "<br/>");

                                });
                            } else {
                                $('#response').show().append(value + "<br/>"); //this is my div with messages
                            }
                        });
                    }
                }
            });

        });




       // $(document).ready(function() {
            function printErrorMsg (msg) {
                $.each( msg, function( key, value ) {
                   $('input[name='+key+']') .addClass('is-invalid');
                   $("'"+key+"_'") .append('<span class="text-danger">'+value+'</span>')

                });
            }
         /*   alert("initi");
            // Handle file input change event
            $('.slider_images').on('change', function() {
                e.preventDefault();


                var file = this.files[0];

                // Create a new FormData object
                var formData = new FormData();
                formData.append('file', file);

                // Send AJAX request
                $.ajax({
                    url: "",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert("init6i");
                        // Handle the response here
                        $('.slider_images').val(response);
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.log(error);
                    }
                });
            });*/
      //  });


    </script>

@endsection
