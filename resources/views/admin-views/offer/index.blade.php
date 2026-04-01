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
                    <a href="{{route('admin.offer.create')}}" class="btn btn-primary waves-effect waves-light">
                        <i class="mdi mdi-plus-circle me-1"></i> إضافة عروض جديده </a>
                </div>
                <h4 class="page-title">عروض </h4>
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
								<th>نوع العرض </th>
                                <th>التاريخ</th>
                                <th>تفعيل</th>
                                <th>الإجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($offers as $offer)
                        
                          
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck{{$offer->id}}">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="table-user"> {{$offer->type}}</td>
                                
                                <td>@if(isset($offer->restaurant->name)){{$offer->restaurant->name}}@endif</td>
                              
								        <td>
                                    <input type="checkbox"  @if($offer->is_active==1) checked @endif  data-plugin="switchery" value="{{$offer->is_active}}" id="change_status" status_id="{{$offer->id}}" data-color="#1bb99a" />
                                </td>
                                <td>
                                    <a href="{{route('admin.offer.edit',['id'=>$offer->id])}}" class="action-icon">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                    <a data-bs-toggle="modal" href="#exampleModalToggle" de role="button" delete-id="{{$offer->id}}" class="action-icon">
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
                            {!! $offers->withQueryString()->links() !!}
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
                    <h4 class="modal-title" id="exampleModalToggleLabel">هل تريد حذف العرض؟</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> بمجرد الضغط علي تأكيد سوف يتم مسح الكوبون نهائياً </div>
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
            url = '{{ route("admin.offer.delete", ":id") }}';
            url = url.replace(':id', id);

        });
        $("#exampleModalToggle .btn-danger").click(function(){
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
               id= $(this).attr('record_id');
               status=this.value;
             // alert(url);
                $.ajax({
                    url:"{{route('admin.offer.change-status')}}",
                    method: 'POST',
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: id,
                        status: status,
                          type:'toggle'
                    },
                    success: function(response) {
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
