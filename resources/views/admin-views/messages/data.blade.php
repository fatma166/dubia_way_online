@php($array=[])
@foreach($conversations as $conv)
{{-- {{ dd($conv) }} --}}

    @if(in_array($conv->sender_id,$array)==false)
        @php(array_push($array,$conv->sender_id))
        @php($user=\App\Models\UserInfo::find($conv->sender_id))
        @php($last_sender=$conv->sender_id)
        {{-- @php($unchecked=\App\Models\Message::where(['conversation_id'=>$conv->id, 'is_seen' => 0])->count()) --}}
        @php($unchecked=($conv->last_message->sender_id != $last_sender)?0:$conv->unread_message_count)

        @if ($user)

            <div
                class="text-body customer-list {{$unchecked!=0?'conv-active':''}}"
                onclick="viewConvs('{{route('admin.message.view',['conversation_id'=>$conv->id,'user_id'=>$conv->sender_id])}}','customer-{{$conv->sender_id}}','{{ $conv->id }}','{{ $conv->sender_id }}')"
                id="customer-{{$conv->sender_id}}">
                <div class="d-flex align-items-start p-2">
                    <img class="me-2 rounded-circle"
                         src="{{asset($user['image'])}}"
                            onerror="this.src='{{asset('assets/images/logo.png')}}'"
                            alt="Image Description" style="width: 42px; height: 42px;"/>

                <div class="w-100">
                    <h5 class="mt-0 mb-0 font-14">
                        <span class="float-end text-muted fw-normal font-12">

                         @if(date('d M Y',strtotime($conv->last_message_time))==date('d M Y')) {{date('H:i',strtotime($conv->last_message_time))}} @elseif(date('Y',strtotime($conv->last_message_time))!= date('Y')) {{date('H:i',strtotime($conv->last_message_time))}} {{date('d M Y',strtotime($conv->last_message_time))}}
                            @else {{date('H:i',strtotime($conv->last_message_time))}}  {{date('d M',strtotime($conv->last_message_time))}} @endif</span>{{$user['f_name'].' '.$user['l_name']}}

                    </h5>
                    <p class="mt-1 mb-0 text-muted font-14">
                                  <span class="w-25 float-end text-end">
                                    <span class="badge badge-soft-danger">{{$unchecked}}</span>
                                  </span>
                        <span class="w-75">{{ $user['phone'] }}</span>
                    </p>
                </div>
                </div>
            </div>
        @else
            <div
                class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list">
                <div class="chat-user-info-img d-none d-md-block">
                    <img class="avatar-img"
                            src='{{asset('assets/images/logo.png')}}'
                            alt="Image Description">
                </div>
                <div class="chat-user-info-content">
                    <h5 class="mb-0 d-flex justify-content-between">
                        <span class=" mr-3">{{__('user_not_found')}}</span>
                    </h5>
                </div>
            </div>
        @endif
    @endif
@endforeach
