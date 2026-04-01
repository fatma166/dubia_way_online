@extends('layouts.vendor.master')
@section('title')
    {{__("index product")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('vendor.product.create')}}" class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus-circle me-1"></i> إضافة منتج </a>
                </div>
                <h4 class="page-title">المنتجات</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-2 mt-sm-0">
                                <!-- here left -->
                            </div>
                        </div><!-- end col-->
                        <div class="col-sm-4">
                            <!-- here right -->
                            <!-- here left -->
                            @php
                                $check = count(request()->query()) > 0 ? '&' : '?';
                            @endphp
                            <div class="text-sm-end">
                            <!-- <a type="button" href="{{-- url()->full() . $check .'export_excel=true'  --}}"
                                           target="_blank" class="btn btn-light mb-2">{{--__('export')--}}
                                    </a>-->
                                <a type="button" href="{{ url()->full() . $check .'print=true'  }}"
                                   target="_blank" class="btn btn-light mb-2">{{__('print')}}
                                </a>
                            </div>
                        </div>
                        <!-- end col-->
                        <!-- end col-->
                    </div>
                    <div class="row mb-2">
                        <form  class="row align-items-end p-2">
                            <div class="col-md-2 col-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{__('name')}}</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           placeholder="{{__('name')}}" value="{{request('name')}}">
                                </div>
                            </div>

                            <div class="col-md-2 col-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">{{__('category')}}</label>
                                    <select id="category_id" name="category_id" class="form-control select2">
                                        <option value="">{{__("select") . ' '. __("	category_")}}</option>
                                        @foreach($categories as $category)
                                            <option
                                                    @if($category->id == request('category_id')) selected
                                                    @endif value="{{$category->id}}">{{ $category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">{{__('status')}}</label>
                                    <select  name="status" class="form-control select2">
                                        <option value="">{{__("select") . ' '. __("status")}}</option>
                                        <option @if(request('status') == 1) selected
                                                @endif value="1">{{__("active")}}</option>
                                        <option @if(request('status') == 0) selected
                                                @endif value="0">{{__("unactive")}}</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 col-6">
                                <div class="mb-3">
                                    <label for="favourite" class="form-label">{{__('favourite')}}</label>
                                    <select  name="favourite" class="form-control select2">
                                        <option value="">{{__("select") . ' '. __("favourite")}}</option>
                                        <option @if(request('favourite') == 1) selected
                                                @endif value="1">{{__("active")}}</option>
                                        <option @if(request('favourite') == 0) selected
                                                @endif value="0">{{__("unactive")}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="mdi mdi-magnify me-1"></i>
                                        {{__("search")}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <!-- here right -->
                            <input  name="advanced_search" class="form-control" onkeyup="search_advance('product')"/>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-2 mt-sm-0">
                                <!-- here left -->
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <div class="append_advanced">
                        @include('vendor-views.product.partials._table')
                    </div>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalToggleLabel">هل تريد حذف المكان ؟</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> بمجرد الضغط علي تأكيد سوف يتم مسح المكان نهائياً </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">تأكيد الحذف</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        let url;
        let id;
        $("#exampleModalToggle").on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget) //Button that triggered the modal

            var id = button.attr('delete-id');
            url = '{{ route("vendor.product.delete", ":id") }}';
            url = url.replace(':id', id);

        });
        $("#exampleModalToggle .btn-danger").click(function(){
           // alert(url);

            $.ajax({
                url: url,
                type: 'DELETE',
                data:{id:id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(result) {
                    // Do something with the result
                   // location.reload();
                }
            });
        });
        $(document).ready(function() {

            $('#change_status').on('change', function() {

                $.ajax({
                    url: '{{route('vendor.category.change-status')}}',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: $('#change_status').attr('status_id'),
                        status: this.value,
                        type:'toggle'
                    },
                    success: function(response) {
                        //  console.log(response);
                        location.reload();
                        // do something with the response data
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        // handle the error case
                    }
                });
            });
        });
    </script>
@endsection

