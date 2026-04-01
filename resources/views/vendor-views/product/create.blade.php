@extends('layouts.vendor.master')
@section('title')
    {{__("create product")}}
@endsection
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
@endpush
@section('content')
<style>
    .bootstrap-tagsinput .tag{background: #0a53be !important;}
</style>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">إضافة منتج</h4>
            </div>
        </div>
    </div>
    <form action="{{route('vendor.product.store')}}" method="post" id="product_form">
        @csrf
    <!-- end page title -->
    <div class="form_edit">

        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">بيانات المنتج</h5>

                        <div class="mb-3 name_">
                            <label for="product-name" class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <input  name="name"  value="{{old("name")}}" type="text" id="product-name" class="form-control @error("name") is-invalid @endError" placeholder="كمثال :  منتج الفلاني">
                            @error("name")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                        </div>



                        <div class="mb-3 description_">

                            <label for="product-description" class="form-label">وصف المنتج <span class="text-danger">*</span></label>
                            <div id="snow-editor" style="height: 150px;"></div> <!-- end Snow-editor-->
                        </div>

                        <div class="mb-3 summary_">
                            <label for="product-summary" class="form-label">ملخص الوصف</label>
                            <textarea name="summary"  value="{{old("description")}}" class="form-control @error("description") is-invalid @endError " id="product-summary" rows="3" placeholder="ادخل ملخص المنتج"></textarea>
                            @error("description")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                        </div>

                        <div class="mb-3 category_id_">
                            <label for="product-category" class="form-label">اختر القسم <span class="text-danger">*</span></label>
                            <select name="category_id"    value="{{old("category_id")}}"  class="form-control select2 @error("category_id") is-invalid @endError " id="product-category">
                                <option value="all">اختر</option>

                                <optgroup label="Shopping">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </optgroup>

                            </select>
                            @error("category_id")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                        </div>

                        <div class="mb-3 price_">
                            <label for="product-price">السعر الإفتراضي<span class="text-danger">*</span></label>
                            <input type="text" name="price" value="{{old("price")}}" class="form-control @error("price") is-invalid @endError " id="product-price" placeholder="ادخل السعر">
                            @error("price")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                        </div>

                        <div class="mb-3 discount_">
                            <label for="product-discount"> الخصم<span class="text-danger"></span></label>
                            <input type="text" name="discount" value="{{old("discount")}}" class="form-control @error("discount") is-invalid @endError" id="product-price" placeholder="ادخل الخصم">
                            @error("discount")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                        </div>
                        <div class="mb-3 discount_type_">
                            <label for="discount-type">نوع الخصم<span class="text-danger"></span></label>

                            <select name="discount_type"  value="{{old("discount_type")}}" class="form-control select2 @error("discount_type") is-invalid @endError " id="product-discount_type">
                                <option value="percent" >نسبه</option>
                                <option value="fixed" >مبلغ</option>

                            </select>
                            @error("discount_type")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-canvas-text"></i>
                            </span>
                                        <span>{{ __('Add Attribute') }}</span>
                                    </h5>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <select name="attribute_id[]" id="choice_attributes"
                                                        class="form-control js-select2-custom"
                                                        multiple="multiple">
                                                    @foreach(\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                                        <option value="{{$attribute['id']}}">{{$attribute['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="customer_choice_options"  id="customer_choice_options">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="variant_combination" id="variant_combination"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        

                        <div class="mb-3 product_quantity_">
                            <label for="product-price">عدد المخزون<span class="text-danger"></span></label>
                            <input type="number"  name="product_quantity"  value="{{old("product_quantity")}}" class="form-control @error("product_quantity") is-invalid @endError" id="product-product_quantity" placeholder="كمثال ٣٤">
                            @error("product_quantity")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                        </div>

                        <div class="mb-3 status_">
                            <label class="mb-2">الحالة <span class="text-danger">*</span></label>
                            <br/>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status" value="1" id="inlineRadio1"  value="{{old("status")}}">
                                    <label class="form-check-label" for="inlineRadio1">منشور</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status" value="0" id="inlineRadio2"  value="{{old("status")}}">
                                    <label class="form-check-label" for="inlineRadio2">مسودة</label>
                                </div>

                            </div>
                        </div>

                        <div class="mb-3 status_">
                            <label class="mb-2">حالة المخزون <span class="text-danger">*</span></label>
                            <br/>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="in_stock" value="1" id="inlineRadio1"  value="{{old("in_stock")}}">
                                    <label class="form-check-label" for="inlineRadio1">في المخزون</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="in_stock" value="0" id="inlineRadio2"  value="{{old("in_stock")}}">
                                    <label class="form-check-label" for="inlineRadio2">غير متوفر</label>
                                </div>

                            </div>
                        </div>
                        <div class="mb-3 status_">
                            <label class="mb-2">سليدر الرئيسه <span class="text-danger">*</span></label>
                            <br/>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="slider_status" value="1" id="inlineRadio1"  value="{{old("slider")}}">
                                    <label class="form-check-label" for="inlineRadio1">نعم</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="slider_status" value="0" id="inlineRadio2"  value="{{old("non-slider")}}">
                                    <label class="form-check-label" for="inlineRadio2">لا</label>
                                </div>

                            </div>
                        </div>
                        
                        <div class="mb-3 status_">
                            <label class="mb-2">المنتج مفضل<span class="text-danger">*</span></label>
                            <br/>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="favourite" value="1" id="inlineRadio1"  value="{{old("slider")}}">
                                    <label class="form-check-label" for="inlineRadio1">نعم</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="favourite" value="0" id="inlineRadio2"  value="{{old("non-slider")}}">
                                    <label class="form-check-label" for="inlineRadio2">لا</label>
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

                            @error("image[]")
                            <span class="text-danger">{{ $message }}</span>
                            @endError
                            <input type="file"  name="image"  id="file-input6"  class="logo_img" data-plugins="dropify" data-max-file-size="1M" accept="image/*"  />

                            <p class="text-muted text-center mt-2 mb-0">يمكنك تحميل صورة التصنيف بحجم لا يتعدي ال ١ ميجا</p>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="document">Documents</label>
                                <div class="needsclick dropzone" id="document-dropzone">
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
                    <button type="button" class="btn w-sm btn-light waves-effect">إلغاء</button>
                    <button type="button" class="btn w-sm btn-success waves-effect waves-light submit_edit">إضافم المنتج</button>

                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->


    </div>
    </form>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
    <script>
        var uploadedDocumentMap = {}
        var name = ''
        Dropzone.options.documentDropzone = {
            url: "{{route('vendor.product.upload_images')}}",
            maxFilesize: 2, // MB
            addRemoveLinks: true,
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

                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                alert(name);
                $.ajax({
                    url: "{{route('vendor.product.delete-image')}}",
                    type: 'DELETE',
                    data: {image:name},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        $('form').find('input[name="file[]"][value="' + name + '"]').remove()
                    }
                });

            },
            init: function () {
                    @if(isset($product) && $project->document)
                var files =
                {!! json_encode($project->document) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="file[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }
    </script>
@endpush
@section('script')

    <script>
        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '" class="choice_no_arr"><input type="text" class="form-control h--45px" name="choice[]" value="' + n + '" placeholder="{{__('messages.choice_title')}}" readonly></div><div class="col-md-9"><input type="text" class="form-control h--45px" name="choice_options_' + i + '[]" placeholder="{{__('messages.enter_choice_values')}}" data-role="tagsinput" onchange="combination_update()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('vendor.product.variant-combination')}}',
                data: $('#product_form').serialize(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }
    </script>



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
            formData = new FormData();
            var fileInput = $('#file-input6'); // Replace 'file-input' with the ID of your file input element
            fileInput.change(function () {
                var file = fileInput[0].files[0];
                //   alert(file);

                formData.append('image', file);
            });



        });
       $('.form_edit .submit_edit').click(function() {
           // $('#product_form').on('submit', function (e) {
//           var formData = new FormData(this);
           // console.log(formData);
            var myEditor = document.querySelector('#snow-editor')
            description1= myEditor.children[0].innerHTML
                formData.append('description', description1);

            name= $('input[name="name"]').val();

            summary=$('textarea[name="summary"]').val();
            category_id=$('select[name="category_id"]').val();
            price=$('input[name="price"]').val();
            discount= $('input[name="discount"]').val();
            product_quantity= $('input[name="product_quantity"]').val();
            status=$('input[name="status"]').val();
            // Retrieve selected attribute IDs from the multi-select
            var attribute_idValues = $('#choice_attributes').val(); // This will give you an array of selected values

// Check if any attributes are selected
            if (attribute_idValues) {
                // Append each selected attribute ID to the FormData
                attribute_idValues.forEach(function(value) {
                    formData.append('attribute_id[]', value); // Use 'attribute_id[]' to match your expected format
                });
            }
            // Retrieve all choice_no values
            var choiceValues = $('input[name="choice[]"]').map(function() {
                return $(this).val();
            }).get(); // This will return an array of all choice_no values

// Append each choice_no value as an array
            choiceValues.forEach(function(value) {
                formData.append('choice[]', value); // Append each value separately
            });
            // To get all choice_no values
            // Retrieve all choice_no values
            var choiceNoValues = $('input[name="choice_no[]"]').map(function() {
                return $(this).val();
            }).get(); // This will return an array of all choice_no values

// Append each choice_no value as an array
            choiceNoValues.forEach(function(value) {
                formData.append('choice_no[]', value); // Append each value separately
            });

// Assuming you already have a choice variable


                // Count the number of values
                var count= choiceNoValues.length;

// Loop through the array to access each value
              /* for (var i = 0; i < count; i++) {
                    $dataaa_choice_options_="choice_options_"+(i+1);
                   var $dataaa_choice_options_= $('input[name="choice_options_'+ (i+1)+'[]"]').map(function() {
                       return $(this).val();
                   }).get();
                   console.log($dataaa_choice_options_);
                  // formData.append("choice_options_"+(i+1), $dataaa_choice_options_);
                   // Append as an array
                   $dataaa_choice_options_.forEach(function(value) {
                       formData.append("choice_options_"+(i+1)+[], value); // Append each value separately

                   });*/
                   for (var i = 0; i < count; i++) {
                       var choiceOptionName = "choice_options_" + (i + 1) + "[]"; // Set the name to indicate it's an array
                       var choiceOptionsValues = $('input[name="choice_options_' + (i + 1) + '[]"]').map(function() {
                           return $(this).val();
                       }).get();

                       console.log(choiceOptionsValues);

                       // Append the entire array as a single entry
                      // formData.append(choiceOptionName, choiceOptionsValues.join(',')); // Join values with a comma

                       // If you want it as an actual array in PHP, loop and append each value
                       choiceOptionsValues.forEach(function(value) {
                           formData.append(choiceOptionName, value); // Append each value separately
                       });
                       $dataaa_choice_options_=choiceOptionsValues;

// Explode the string into separate values
                    /*   var explodedValues = $dataaa_choice_options_[0].split(',');
                   var explodedValuescount= explodedValues.length;
                   for (var ei = 0; ei < explodedValuescount; ei++) {
                       $explode_price =$('input[name="price_'+explodedValues[ei]+'"]').val();
                       console.log("price_"+explodedValues[ei]+"value"+$explode_price);

                       formData.append("price_"+explodedValues[ei], $explode_price);
                   }*/

                    /*$dataaa_choice_options_= $('input[name="choice_options_"'+ (i+1)+']').val();
                    alert($dataaa_choice_options_);
                    formData.append('choice_options_'+(i+1), $dataaa_choice_options_);
                    formData.append('price_'+(i+1), $dataaa_choice_options_);
                   // console.log('Value at index ' + (i+1) + ': ' + [i]);*/
                }

           var labelTexts = $('#variant_combination tbody label.control-label').map(function() {
               var labelText = $(this).text(); // Get the text of each label
               var priceInputValue = $('input[name="price_' + labelText + '"]').val(); // Get the corresponding input value

               formData.append("price_" + labelText, priceInputValue); // Append to formData

               return labelText; // Return the label text for the array
           }).get(); // Convert jQuery object to a regular array
            //  image=formData;//$('.logo_img').val();

//            alert($('input[name="category_id"]').val());
            url="{{route('vendor.product.store')}}";
            formData.append('name', name);
            formData.append('description', description1);
            formData.append('summary', summary);
            formData.append('category_id', category_id);
            formData.append('price', price);
            formData.append('discount', discount);
            formData.append('product_quantity', product_quantity);
            formData.append('status', status);
           // formData.append('attribute_id', attribute_id);

           console.log(formData);

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


    <script>
       /* "use strict";
        $('#stock_type').on('change', function () {
            if($(this).val() == 'unlimited') {
                $('.stock_disable').prop('readonly', true).prop('required', false).attr('placeholder', 'Unlimited').val('');
                $('.hide_this').addClass('d-none');
            } else {
                $('.stock_disable').prop('readonly', false).prop('required', true).attr('placeholder', 'Ex: 100');
                $('.hide_this').removeClass('d-none');
            }
        });

        updatestockCount();

        function updatestockCount(){
            if($('#stock_type').val()==  'unlimited'){
                $('.stock_disable').prop('readonly', true).prop('required', false).attr('placeholder', 'Unlimited').val('');
                $('.hide_this').addClass('d-none');
            } else{
                $('.stock_disable').prop('readonly', false).prop('required', true).attr('placeholder', 'Ex: 100');
                $('.hide_this').removeClass('d-none');
            }
        }*/
        $(document).ready(function() {
            $("#add_new_option_button").click(function(e) {
                $('#empty-variation').hide();
                count++;
                let add_option_view = `
                    <div class="__bg-F8F9FC-card view_new_option mb-2">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-check form--check">
                                    <input id="options[` + count + `][required]" name="options[` + count + `][required]" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">Required</span>
                                </label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete_input_button"
                                        title="Delete">
                                        <i class="tio-add-to-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-xl-4 col-lg-6">
                                    <label for="">Name&nbsp;<span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="Required."> *
                                </span></label>
                                    <input required name=options[` + count +
                    `][name] class="form-control new_option_name" type="text" data-count="`+
                    count +`">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label class="input-label text-capitalize d-flex align-items-center"><span class="line--limit-1">Variation Selection Type </span>
                                        </label>
                                        <div class="resturant-type-group px-0">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input show_min_max" data-count="`+count+`" type="radio" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked
                                                >
                                                <span class="form-check-label">
                                                    Multiple Selection
                    </span>
                </label>

                <label class="form-check form--check mr-2 mr-md-4">
                    <input class="form-check-input hide_min_max" data-count="`+count+`" type="radio" value="single"
                    name="options[` + count + `][type]" id="type` + count +
                    `"
                                                >
                                                <span class="form-check-label">
                                                    Single Selection
                    </span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="row g-2">
            <div class="col-6">
                <label for="">Min</label>
                                            <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">Max</label>
                                            <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="option_price_` + count + `" >
                                <div class="bg-white border rounded p-3 pb-0 mt-3">
                                    <div  id="option_price_view_` + count + `">
                                        <div class="row g-3 add_new_view_row_class mb-3">
                                            <div class="col-md-3 col-sm-6">
                                                <label for="">Option name &nbsp;<span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="Required."> *
                                </span></label>
                                                <input class="form-control" required type="text" name="options[` +
                    count +
                    `][values][0][label]" id="">
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <label for="">Additional price ($)&nbsp;<span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="Required."> *
                                </span></label>
                                                <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                    count + `][values][0][optionPrice]" id="">
                                            </div>
                                            <div class="col-md-3 col-sm-6 hide_this">
                                                <label for="">Stock</label>
                                                <input class="form-control stock_disable count_stock" required type="number" min="0" max="9999999" name="options[` +
                    count + `][values][0][total_stock]" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                    `">
                                        <button type="button" class="btn btn--primary btn-outline-primary add_new_row_button" data-count="`+
                    count +`">Add New Option</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $("#add_new_option").append(add_option_view);
                updatestockCount();
            });
        });


        function add_new_row_button(data) {
            countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
            let add_new_row_view = `
            <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
                <div class="col-md-3 col-sm-5">
                        <label for="">Option name &nbsp;<span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="Required."> *
                                </span></label>
                        <input class="form-control" required type="text" name="options[` + data + `][values][` + countRow + `][label]" id="">
                    </div>
                    <div class="col-md-3 col-sm-5">
                        <label for="">Additional price ($)&nbsp;<span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="Required."> *
                                </span></label>
                        <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
                data + `][values][` + countRow + `][optionPrice]" id="">
                    </div>


                    <div class="col-md-3 col-sm-6 hide_this">
                                                <label for="">Stock</label>
                                                <input class="form-control stock_disable count_stock" required type="number" min="0" max="9999999" name="options[` +
                data + `][values][` + countRow + `][total_stock]" id="">
                                            </div>


                    <div class="col-sm-2 max-sm-absolute">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <div class="mt-1">
                            <button type="button" class="btn btn-danger btn-sm deleteRow"
                                title="Delete">
                                <i class="tio-add-to-trash"></i>
                            </button>
                        </div>
                </div>
            </div>`;
          //  $('#option_price_view_' + data).append(add_new_row_view);
          //  updatestockCount();

        }


    </script>
@endsection
