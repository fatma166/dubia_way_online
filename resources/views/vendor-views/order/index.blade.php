@extends('layouts.vendor.master')
@section('title')
    {{__("index order")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">الطلبات</h4>
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
                            <!-- here right -->

                        </div>
                        <div class="col-sm-4">

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
                    </div>
                    <form  class="row align-items-end p-2">
                        <div class="col-md-3 col-6">
                            <div class="mb-3">
                                <label for="client_name" class="form-label">{{__('client')}}</label>
                                <select id="user_id" name="user_id" class="form-control select2">
                                    <option value="">{{__("select") . ' '. __("users")}}</option>
                                    @foreach($users as $user)
                                        <option
                                                @if($user->id == request('user_id')) selected
                                                @endif value="{{$user->id}}">{{ $user->f_name ." " .$user->l_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-2 col-6">
                            <div class="mb-3">
                                <label for="order_status" class="form-label">{{__('status')}}</label>
                                <select id="order_status" name="order_status" class="form-control select2">
                                    <option value="">{{__("select") . ' '. __("status")}}</option>
                                    <option @if(request('order_status') == 'canceled') selected
                                            @endif value="canceled">{{__("canceled")}}</option>
                                    <option @if(request('order_status') == 'processing') selected
                                            @endif value="processing">{{__("processing")}}</option>
                                    <option @if(request('order_status') == 'pending') selected
                                            @endif value="pending">{{__("pending")}}</option>
                                    <option @if(request('order_status') =='delivered') selected
                                            @endif value="delivered">{{__("delivered")}}</option>
                                    <option @if(request('order_status') =='confirmed') selected
                                            @endif value="confirmed">{{__("confirmed")}}</option>
                                    <option @if(request('order_status') =='not_responed') selected
                                            @endif value="not_responed">{{__("not_responed")}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-3">
                            <div class="mb-3">
                                <label for="example-date" class="form-label">من</label>
                                <input class="form-control @error("from") is-invalid @endError" name="from" id="example-date" type="date" >
                                @error("from")
                                <span class="text-danger">{{ $message }}</span>
                                @endError
                            </div>
                        </div>
                        <div class="col-md-2 col-3">
                            <div class="mb-3">
                                <label for="example-date" class="form-label">الي</label>
                                <input class="form-control @error("to") is-invalid @endError" name="to" id="example-date" type="date" >
                                @error("to")
                                <span class="text-danger">{{ $message }}</span>
                                @endError
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

                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <!-- here right -->
                            <input  name="advanced_search" class="form-control" onkeyup="search_advance('order')"/>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-2 mt-sm-0">
                                <!-- here left -->
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <div class="append_advanced">
                        @include('vendor-views.order.partials._table')
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
