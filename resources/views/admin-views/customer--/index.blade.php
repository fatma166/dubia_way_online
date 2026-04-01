@extends('layouts.admin.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('admin.place.create')}}" class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus-circle me-1"></i> إضافة صاحب محل </a>
                </div>
                <h4 class="page-title">أصحاب المحلات</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-primary">
                                    <i class="dripicons-store font-24 avatar-title text-primary"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{$data['place_count']}}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">الاماكن</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-success">
                                    <i class="dripicons-store font-24 avatar-title text-success"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{$data['place_active_count']}}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">الاماكن المفعلة</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-info">
                                    <i class="dripicons-store font-24 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{$data['place_inactive_count']}}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate"> غير مفعلة</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-lg rounded bg-soft-warning">
                                    <i class="dripicons-store font-24 avatar-title text-warning"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">
                                        <span data-plugin="counterup">{{$data['place_recent_count']}}</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">اماكن جديدة</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                </div>
                <!-- end widget-rounded-circle-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row -->
    </div>
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
                                <th>صاحب المكان</th>
                                <th>العنوان</th>
                                <th>التصنيف</th>
                                <th>تاريخ الإنشاء</th>
                                <th>عدد المنتجات</th>
                                <th>المحفظة</th>
                                <th>الحالة</th>
                                <th style="width: 85px;">الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($places as $place)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox"  name="id" value="{{$place->id}}"class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="table-user">
                                    <img src="{{asset($place->image)}}" alt="table-user" class="me-2 rounded-circle"   onerror="this.src='{{asset('assets/images/logo.png')}}'" >
                                    <a href="javascript:void(0);" class="text-body fw-semibold">{{$place->name}}</a>
                                </td>
                                <td>@if(($place->vendor)!=null){{$place->vendor->f_name}}  {{$place->vendor->l_name}}@endif</td>
                                <td> {{$place->address}} </td>
                                <td> {{$place->compilation->title}} </td>
                                <td> {{$place->created_at}}</td>
                                <td>@if(isset($place->foods_count)){{$place->foods_count}} @endif</td>
                                <td></td>
                                <td>
                                    <input type="checkbox" @if($place->status==1) checked @endif  data-plugin="switchery" data-color="#1bb99a" />
                                </td>
                                <td>
                                    <a href="{{route('admin.place.details',['id'=>$place->id])}}" class="action-icon">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{route('admin.place.edit',['id'=>$place->id])}}" class="action-icon">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                    <a data-bs-toggle="modal" href="#exampleModalToggle" role="button" delete-id={{$place->id}} class="action-icon">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    @if(!request()->filled("print"))
                        <div class="pagination pagination-rounded justify-content-end mb-0">
                            {!! $places->withQueryString()->links() !!}
                        </div>
                    @endif
                   {{-- <ul class="pagination pagination-rounded justify-content-end mb-0">
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="javascript: void(0);">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);">5</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                <span aria-hidden="true">»</span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </li>
                    </ul>--}}
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
<!-- all models -->
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
    url = '{{ route("admin.place.delete", ":id") }}';
    url = url.replace(':id', id);

    });
    $("#exampleModalToggle .btn-danger").click(function(){
        alert(url);

        $.ajax({
            url: url,
            type: 'DELETE',
            data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(result) {
                // Do something with the result
                location.reload();
            }
        });
    });

    </script>
@endsection
