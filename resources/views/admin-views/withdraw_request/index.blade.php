@extends('layouts.admin.master')
@section('title')
    {{__("withdraw request")}}
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">طلبات سحب أصحاب المحلات</h4>
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
                        <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                            <thead>
                            <tr>
                                <th style="width: 20px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th>اسم المكان</th>
                                <th>المبلغ</th>
                                <th>اسم صاحب الحساب</th>
                                <th>رقم الحساب</th>
                                <th>اسم البنك</th>
                                <th>فرع البنك</th>
                                <th>تاريخ الطلب</th>
                                <th>الحالة</th>
                                <th style="width: 85px;">الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(($withdraws->count())>0)
                                @foreach($withdraws as $withdraw)
                                    @if(!isset($withdraw->vendor->restaurants))

                                        @continue
                                    @endif
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.place.details',['id'=>$withdraw->vendor->restaurants[0]->id])}}">{{$withdraw->vendor->restaurants[0]->name}}</a>
                                        </td>
                                        <td>{{$withdraw->amount}} {{__(config('app.currency'))}}</td>
                                        <td>{{$withdraw->vendor->f_name}} {{$withdraw->vendor->l_name}}</td>
                                        <td>{{$withdraw->vendor->account_no}}</td>
                                        <td>{{$withdraw->vendor->bank_name}}</td>
                                        <td>{{$withdraw->vendor->branch}}</td>
                                        <td>{{Carbon\Carbon::parse($withdraw->vendor->creared_at)->translatedFormat('l j F Y H:i:s')}}</td>

                                        <td>
                                            <span class="@if($withdraw->approved==1) badge bg-soft-success text-success @else badge bg-soft-warning text-warning @endif">@if($withdraw->approved==1) {{__('approved')}}@else {{__('in wait')}} @endif</span>

                                        </td>
                                        @if($withdraw->approved==0)
                                            <td>
                                                <a data-bs-toggle="modal" href="#exampleModalToggle"   data-id="{{$withdraw->id}}"  role="button" class="action-icon change_status_convert">
                                                    <i class="mdi mdi-checkbox-marked-circle"></i>
                                                </a>

                                            </td>
                                        @else
                                            <td></td>
                                        @endif
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
                            {!! $withdraws->withQueryString()->links() !!}
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalToggleLabel">هل قمت بتحويل الاموال ؟</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">رسالة تأكيد بإرسالك الأموال إلي صاحب المكان </div>
                <div class="modal-footer">
                    <button  class="btn btn-primary confirm" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">تأكيد</button>
                    <button class="btn btn-danger cancle" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">رفض</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@section('script')
    <script>
        var id;

        $("#exampleModalToggle").on('show.bs.modal', function(event) {


            var button = $(event.relatedTarget) //Button that triggered the modal

           id = button.attr('data-id');
        });

        $(".confirm").click(function(){

            $.ajax({
                url:"{{route('admin.withdraw.change-status')}}",
                data:{id:id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post"
            }).done(function(data) {
                location.reload(true);

            });

        });
        $(".cancle").click(function(){
            $('#exampleModalToggle').modal().hide();


        });

    </script>


@endsection
