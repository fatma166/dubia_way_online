@extends('layouts.admin.master')
@section('title')
    {{__("zone")}}
@endsection
@section('content')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('admin.zone.create')}}" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> إضافة منطقه</a>
                </div>
                <h4 class="page-title">قائمة المناطق </h4>
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
                        </div><!-- end col-->
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
                                <th>الترقيم</th>
                                <th>الاسم</th>
                                <th>تاريخ إنشاء المنطقه</th>
                                <th>تفعيل</th>
                                <th>الإجراء</th>

                            </tr>
                            </thead>
                            <tbody>
                            @if($zones->count()>0)
                                @foreach($zones as $key=>$zone)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck{{$zone->id}}">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            {{$key+1}}
                                        </td>
                                        <td>{{$zone->name}}</td>
                                        <td>{{ \Carbon\Carbon::parse($zone->created_at)->translatedFormat('l j F Y H:i:s') }}</td>

                                        <td>
                                            <input type="checkbox"  @if($zone->status==1) checked @endif  data-plugin="switchery" value="{{$zone->status}}" id="change_status" status_id="{{$zone->id}}" data-color="#1bb99a" />
                                        </td>

                                        <td>
                                            <a href="{{route('admin.zone.edit', ['id' => $zone->id])}}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="{{route('admin.zone.delete', ['id' => $zone->id])}}" class="action-icon"> <i class="mdi mdi-delete"></i></a>

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
                            {!! $zones->withQueryString()->links() !!}
                        </div>
                    @endif

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

@endsection
@push('script')

    <script>
        let url;
        let id;
        $("#exampleModalToggle").on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget) //Button that triggered the modal

            var id = button.attr('delete-id');
            url = '{{ route("admin.zone.delete", ":id") }}';
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
                    url: '{{route('admin.zone.change-status')}}',
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
@endpush




