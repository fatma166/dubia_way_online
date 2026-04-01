<div class="table-responsive">
    <table class="table table-centered table-nowrap table-striped" id="products-datatable">
        <thead>
        <tr>
            <th style="width: 20px;">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="customCheck1">
                    <label class="form-check-label" for="customCheck1">&nbsp;</label>
                </div>
            </th>
            <th>رقم الطلب</th>
            <th>تاريخ الطلب</th>
            <th>بيانات العميل</th>
            <!-- <th>اسم المكان</th>-->
            <th>إجمالي الفاتورة</th>
            <th>الحالة</th>
            <th style="width: 85px;">الإجراء</th>
        </tr>
        </thead>
        <tbody>
        @if(($orders!=null)&&($orders->count())>0)
            @foreach($orders as $order)
                @if(!isset($order->restaurant->name))

                    @continue
                @endif
                <tr>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheck{{$order->id}}">
                            <label class="form-check-label" for="customCheck2">&nbsp;</label>
                        </div>
                    </td>
                    <td> {{$order->id}} </td>
                    <td> {{\Carbon\Carbon::parse($order->created_at)->translatedFormat('l j F Y H:i:s')}}</td>
                    <td>@if(isset($order->customer_address->contact_person_name)){{$order->customer_address->contact_person_name}}<br>{{$order->customer_address->contact_person_number}}@else {{__('notfound')}} @endif</td>
                <!--  <td class="table-user">
                                    <img src="{{--asset($order->logo)--}}" alt="table-user" class="me-2 rounded-circle" onerror="this.src='{{--asset('assets/images/avatar.svg')--}}'">
                                    <a href="javascript:void(0);" class="text-body fw-semibold">{{--$order->restaurant->name--}}</a>
                                </td>-->
                    <td>{{$order->order_amount}} {{__(config('app.currency'))}}  </td>
                    <td>
                        <span class="badge  @if($order->order_status=='pending') {{'bg-warning rounded-pill'}}@elseif($order->order_status=='delivered'){{'bg-soft-success text-success'}}@elseif($order->order_status=='canceled'){{'bg-danger rounded-pill '}}@elseif($order->order_status=='processing'){{'bg-warning rounded-pill'}}@elseif($order->order_status=='confirmed'){{'bg-warning rounded-pill'}}@endif">@if($order->order_status=='pending') {{__('pending')}}@elseif($order->order_status=='delivered'){{__('delivered')}} @elseif($order->order_status=='canceled'){{__('canceled')}}  @elseif($order->order_status=='processing'){{__('processing')}} @elseif($order->order_status=='confirmed'){{__('confirmed')}}@elseif($order->order_status=='not_responed'){{__('not_responed')}}  @endif </span>
                    </td>
                    <td>
                        <a href="{{route('vendor.order.details',['id'=>$order->id])}}" class="action-icon">
                            <i class="mdi mdi-eye"></i>
                        </a>
                        <a href="{{route('vendor.order.details',['id'=>$order->id,'print'=>true])}}" class="action-icon">
                            <i class="mdi mdi-printer"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9" class="text-center">
                    {{__('no data available')}}
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
@if(!request()->filled("print")&&$orders!=null)
    <div class="pagination pagination-rounded justify-content-end mb-0">
        {!! $orders->withQueryString()->links() !!}
    </div>
@endif