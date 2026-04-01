@extends('layouts.admin.master')
@section('title')
    {{__("create_admin_role")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">إضافة دور جديد</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <form action="{{route('admin.role.store')}}" method="post"   enctype="multipart/form-data">
            @csrf
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="projectname" class="form-label">اسم الدور</label>
                                <input type="text" name="name" id="projectname" class="form-control @error("name") is-invalid @endError" placeholder="ادخل هنا اسم الدور">
                                @error("name")
                                <span class="text-danger">{{ $message }}</span>
                                @endError
                            </div>
                            <div class="mb-3">
                                @error("modules")
                                <span class="text-danger">{{ $message }}</span>
                                @endError
                                <div class="form-check mb-2 form-check-success">
                                    <input class="form-check-input"  name="modules[]" type="checkbox" value="offers" id="customckeck2">
                                    <label class="form-check-label" for="customckeck2">مدير العروض الترويجية</label>
                                </div>
                                <div class="form-check mb-2 form-check-success">
                                    <input class="form-check-input"  name="modules[]"  type="checkbox" value="places" id="customckeck2">
                                    <label class="form-check-label" for="customckeck2">إدارة أصحاب المحلات</label>
                                </div>
                                <div class="form-check mb-2 form-check-success">
                                    <input class="form-check-input"   name="modules[]" type="checkbox" value="order_clients" id="customckeck2">
                                    <label class="form-check-label" for="customckeck2">إدارة العملاء</label>
                                </div>
                                <div class="form-check mb-2 form-check-success">
                                    <input class="form-check-input"  name="modules[]" type="checkbox" value="chat" id="customckeck2">
                                    <label class="form-check-label" for="customckeck2">إدارة المساعدة</label>
                                </div>
                                <div class="form-check mb-2 form-check-success">
                                    <input class="form-check-input" type="checkbox" name="modules[]" value="withdraw_payment" id="customckeck2">
                                    <label class="form-check-label" for="customckeck2">إدارة عمليات البيع</label>
                                </div>
                                <div class="form-check mb-2 form-check-success">
                                    <input class="form-check-input" type="checkbox"  name="modules[]" value="admin_role_employee" id="customckeck2">
                                    <label class="form-check-label" for="customckeck2">إدارة الموظفين</label>
                                </div>
                                <div class="form-check mb-2 form-check-success">
                                    <input class="form-check-input" type="checkbox"  name="modules[]"value="report" id="customckeck2">
                                    <label class="form-check-label" for="customckeck2">إدارة التقارير</label>
                                </div>
                            </div>

                        </div>
                        <!-- end col-->
                        <div class="col-lg-6"></div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card-->
            <!-- cta -->
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light m-1">
                        <i class="fe-check-circle me-1"></i> إنشاء مدير </button>
                    <button type="button" class="btn btn-light waves-effect waves-light m-1">
                        <i class="fe-x me-1"></i> إلغاء </button>
                </div>
            </div>
            <!-- cta -->
        </div>
        <!-- end col-->
        </form>
    </div>
    <!-- end row-->


@endsection
@section('script')


    <script>


        var loadFile = function (event) {
            var output = document.getElementById('output');
            if (event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src) // free memory
                };

            } else {
                output.src = '';
            }

        };


    </script>
    @endsection

