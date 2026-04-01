@extends('layouts.vendor.master')
@section('title')
    {{__("index category")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('vendor.category.create')}}" class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus-circle me-1"></i> إضافة تصنيف </a>
                </div>
                <h4 class="page-title">التصنيفات</h4>
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
                                <th>ID</th>
                                <th>اسم التصنيف</th>
                                <th>الحالة</th>
                                <th style="width: 85px;">الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(($categories!=null)&&($categories->count())>0)
                                @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck2">
                                            <label class="form-check-label" for="customCheck{{$category->id}}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td> {{$category->id}} </td>
                                    <td>{{$category->name}}</td>
                                    <td>
                                        <input type="checkbox"  @if($category->status==1) checked @endif  data-plugin="switchery" value="{{$category->status}}" id="change_status" status_id="{{$category->id}}" data-color="#1bb99a" />
                                    </td>
                                    <td>
                                        <a href="{{route('vendor.category.edit',['id'=>$category->id])}}" class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        <a data-bs-toggle="modal" href="#exampleModalToggle" role="button" class="action-icon" delete-id={{$category->id}} >
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
                            {!! $categories->withQueryString()->links() !!}
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
            url = '{{ route("vendor.category.delete", ":id") }}';
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

