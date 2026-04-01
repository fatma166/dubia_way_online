<div class="card">
        <div class="card-body py-2 px-3 border-bottom border-light">
            <div class="row justify-content-between py-1">
                <div class="col-sm-7">
                    <div class="d-flex align-items-start">
                        <img src="{{asset($user['image'])}}" class="me-2 rounded-circle" height="36" onerror="this.src='{{asset('assets/images/logo.png')}}'"
                             alt="Image Description">
                        <div>
                            <h5 class="mt-0 mb-0 font-15">
                                <a href="contacts-profile.html" class="text-reset">  {{$user['f_name'].' '.$user['l_name']}}</a>
                            </h5>
                            <p class="mt-1 mb-0 text-muted font-12"> {{ $user['phone'] }} </p>
                        </div>
                    </div>
                </div>
            </div>
            </div>



    <div class="card-body">
        <ul class="conversation-list scroll-down" data-simplebar style="max-height: 460px;">
            @foreach($convs as $con)

            <li class="clearfix @if($con->sender_id != $receiver->id)odd @endif">
                <div class="chat-avatar">
                    <img src="{{asset($user->avatar)}}" class="rounded" onerror="this.src='{{asset('assets/images/logo.png')}}'"/>
                    <i>
                       <span> @if(date('d M Y',strtotime($con->created_at))==date('d M Y')) {{date('H:i',strtotime($con->created_at))}} @elseif(date('Y',strtotime($con->created_at))!= date('Y')) {{date('d M Y',strtotime($con->created_at))}} {{date('H:i',strtotime($con->created_at))}}
                        @else {{date('d M',strtotime($con->created_at))}} {{date('H:i',strtotime($con->created_at))}}@endif</span>

                    </i>
                </div>
                <div class="conversation-text">
                    <div class="ctext-wrap">
                        <i>{{$user['f_name'].' '.$user['l_name']}}</i>
                        <p>{{$con->message}}
                        @if($con->file!=null)
                            @foreach(json_decode($con->file) as $img)
                                <br>
                                    <img class="w-100" src="{{asset($img)}}"   onerror="this.src='{{asset('assets/images/logo.png')}}'">
                            @endforeach
                        @endif
                        </p>

                    </div>
                </div>
            </li>
            @endforeach
                <div id="scroll-here"></div>
        </ul>

        <div class="row">
            <div class="col">
                <div class="mt-2 bg-light p-3 rounded">
                    <form class="needs-validation" novalidate="" name="chat-form" action="javascript:" method="post" id="reply-form" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <div class="col mb-2 mb-sm-0">
                                <input type="text" class="form-control border-0" name="reply" placeholder="من فضلك أدخل الرسالة" required="" />
                                <div class="invalid-feedback"> من فضلك أدخل الرسالة </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="btn-group">
                                    <span class="btn btn-light" id="attach__">
                                        <i class="fe-paperclip"></i>
                                    </span>
                                    <button type="submit" class="btn btn-success chat-send w-100"
                                            {{-- onclick="replyConvs('{{route('admin.message.store',[$user->id])}}')" --}}
                                            class="btn btn-primary btn--primary con-reply-btn"> <i class="fe-send"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row-->
                    </form>
                </div>
            </div>
            <!-- end col-->
        </div>
        <!-- end row -->
    </div>


</div>
<script src="{{asset('assets/js/spartan-multi-image-picker.js')}}"></script>
<script>
    $(document).ready(function () {
        $(".conversation-list").scrollTop( $(".conversation-list").prop('scrollHeight'));
        $('.scroll-down').animate({
            scrollTop: $('#scroll-here').offset().top
        },0);
    });


    $(function() {
        $("#attach__").spartanMultiImagePicker({
            fieldName: 'images[]',
            maxCount: 3,
            rowHeight: '10px',
            groupClassName: 'attc--img',
            maxFileSize: '',

            dropFileLabel: "Drop Here",
            onAddRow: function(index, file) {

            },
            onRenderedPreview: function(index) {

            },
            onRemoveRow: function(index) {

            },
            onExtensionErr: function(index, file) {
                toastr.error('{{ __('please_only_input_png_or_jpg_type_file') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
            onSizeErr: function(index, file) {
                toastr.error('{{ __('file_size_too_big') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
    });


    $('#reply-form').on('submit', function() {

        $('button[type=submit], input[type=submit]').prop('disabled',true);
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.message.store', [$user->user_id]) }}',
                data: $('reply-form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    if (data.errors && data.errors.length > 0) {
                        toastr.error('Reply message is required!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else{

                      /*  toastr.success('Message sent', {
                            CloseButton: true,
                            ProgressBar: true
                        });*/

                        $('#view-conversation').html(data.view);
                       // $('.conversation-list').scrollTop(500);

                    }
                },
                error() {
                    toastr.error('Reply message is required!', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
</script>
