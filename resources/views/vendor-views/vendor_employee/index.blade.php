@extends('layouts.admin.master')
@section('title')
    {{__("index_admin_employee")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('admin.employee.create')}}"  class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus-circle me-1"></i> إضافة موظف </a>
                </div>
                <h4 class="page-title">الأدوار</h4>
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
                                <th>اسم الموظف</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الدور</th>
                                <th>الحالة</th>
                                <th style="width: 85px;">الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($employees->count()>0)
                                @foreach($employees as $employee)
                                     <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck{{$employee->id}}">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="table-user">
                                    <img src=" {{asset($employee->image)}}" alt="table-user" class="me-2 rounded-circle"   onerror="this.src='{{asset('assets/images/logo.png')}}'">
                                    <a href="javascript:void(0);" class="text-body fw-semibold">{{$employee->f_name}}  {{$employee->l_name}}</a>
                                </td>
                                <td> {{$employee->email}}</td>
                                <td>{{$employee->phone}}</td>
                                  <td>{{Carbon\Carbon::parse($employee->creared_at)->translatedFormat('l j F Y H:i:s')}}</td>
                                <td> {{$employee->role->name}} </td>
                                <td>
                                    <input type="checkbox"  @if($employee->status==1) checked @endif  data-plugin="switchery" value="{{$employee->status}}" id="change_status" status_id="{{$employee->id}}" data-color="#1bb99a" />
                                </td>
                                <td>
                                    <a href="{{route('admin.employee.edit',['id'=>$employee->id])}}" class="action-icon">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                    <a href="{{route('admin.employee.delete',['id'=>$employee->id])}}" class="action-icon">
                                        <i class="mdi mdi-delete"></i>
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
                            {!! $employees->withQueryString()->links() !!}
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

    <script>

        $(document).ready(function() {

            $('#change_status').on('change', function() {

                $.ajax({
                    url: '{{route('admin.employee.change-status')}}',
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
