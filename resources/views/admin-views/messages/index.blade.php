@extends('layouts.admin.master')
@section('title')
    {{__("chat")}}
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('chat') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <!-- start chat users-->
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <!-- start search box -->
                        <form class="search-bar mb-3">
                            <div class="position-relative">
                                <input type="text" class="form-control form-control-light" id="serach"  placeholder="ابحث عن مستخدم">
                                <span class="mdi mdi-magnify"></span>
                            </div>
                        </form>

                        <!-- end search box -->
                        <h6 class="font-13 text-muted text-uppercase mb-2">المستخدمين</h6>
                        <!-- users -->
                        <div class="row">
                            <div class="col">
                                <div  style="max-height: 375px;" id="conversation-list">
                                        @include('admin-views.messages.data')
                                </div>
                                <!-- end slimscroll-->
                            </div>
                            <!-- End col -->
                        </div>
                        <!-- end users -->
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end chat users-->
            <!-- chat area -->
            <div class="col-xl-9 col-lg-8" id="view-conversation">

            </div>
        </div>
        <!-- end row-->
    </div>

@endsection

@push('script')
{{--<script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>--}}

    <script>
        function viewConvs(url, id_to_active, conv_id, sender_id) {

            $('.customer-list').removeClass('conv-active');
            $('#' + id_to_active).addClass('conv-active');
            let new_url= "{{ route('admin.message.list') }}" + '?conversation=' + conv_id+ '&user=' + sender_id;
            $.get({
                url: url,
                success: function(data) {
                    window.history.pushState('', 'New Page Title', new_url);

                    $('#view-conversation').html(data.view);
                    $('.conversation-list').scrollTop(400);

                }
            });

        }
        var page = 1;
        $('#conversation-list').scroll(function() {
            if ($('#conversation-list').scrollTop() + $('#conversation-list').height() >= $('#conversation-list')
                .height()) {
                page++;
                loadMoreData(page);
            }
        });

        function loadMoreData(page) {
            $.ajax({
                    url: "{{ route('admin.message.list') }}" + '?page=' + page,
                    type: "get",
                    beforeSend: function() {

                    }
                })
                .done(function(data) {
                    if (data.html == " ") {
                        return;
                    }
                    $("#conversation-list").append(data.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('server not responding...');
                });
        }

        function fetch_data(page, query) {
            $.ajax({
                url: "{{ route('admin.message.list') }}" + '?page=' + page + "&key=" + query,
                success: function(data) {
                    $('#conversation-list').empty();
                    $("#conversation-list").append(data.html);
                }
            })
        }

        $(document).on('keyup', '#serach', function() {
            var query = $('#serach').val();
            fetch_data(page, query);
        });
    </script>
@endpush
