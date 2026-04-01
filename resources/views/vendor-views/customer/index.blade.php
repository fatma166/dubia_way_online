@extends('layouts.vendor.master')
@section('title')
    {{__("index customer")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">العملاء</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <!-- here right -->
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-2 mt-sm-0">
                                <!-- here left -->
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-bordered" id="products-datatable">
                            <thead>
                            <tr>
                                <th style="width: 20px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th>اسم العميل</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>إجمالي الطلبات</th>
                                <th>الحالة</th>
                                <th style="width: 85px;">الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(($users!=null)&&($users->count())>0)
                                @foreach($users as $user)
                            <tr>

                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck{{$user->id}}">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="table-user">
                                    <a href="javascript:void(0);" class="text-body fw-semibold">{{$user->f_name}} {{--$user->l_name--}}</a>
                                </td>
                                <td> {{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td> {{$user->orders_count}} طلب </td>
                                <td>
                                    <input type="checkbox"  @if($user->active==1) checked @endif  data-plugin="switchery" value="{{$user->active}}" class="change_status"  status_id="{{$user->id}}" data-color="#1bb99a" />
                                </td>
                                <td>
                                    <a href="{{route('vendor.customer.view',['id'=>$user->id])}}" class="action-icon">
                                        <i class="mdi mdi-eye"></i>
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

                    @if(!request()->filled("print"))
                        <div class="pagination pagination-rounded justify-content-end mb-0">
                            {!! $users->withQueryString()->links() !!}
                        </div>
                    @endif
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        let url;
        let id;

        $(document).ready(function() {

            $('.change_status').on('change', function() {
                $.ajax({
                    url: '{{route('vendor.customer.change-status')}}',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: $(this).attr('status_id'),
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
