@extends('layouts.admin.master')
@section('title')
    {{__("index")}}
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">شحن محفظة العميل</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.customer-wallet.store-charge-wallet')}}" method="post" id="banner_form"  enctype="multipart/form-data">
                @csrf
                <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="selectmethod" class="form-label">اختر العميل</label>
                                        <select id="selectmethod"  name="user_id" class="form-control" data-toggle="select2" data-width="100%">
                                           @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->f_name}}{{$user->l_name}}</option>
                                           @endforeach
                                        </select>
                                        @error("user_id")
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="mb-3">
                                        <label for="projectname" class="form-label">ادخل المبلغ المراد شحنة</label>
                                        <input type="text" name="amount" class="form-control" placeholder="ادخل المبلغ كمثال : ٢٢٢">
                                    </div>
                                </div>
                                <!-- end col-->
                                <div class="col-lg-6"></div>
                            </div>
                            <!-- end row -->
                            <!-- cta -->
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light m-1">
                                        <i class="fe-check-circle me-1"></i> شحن المحفظة </button>
                                    <button type="button" class="btn btn-light waves-effect waves-light m-1">
                                        <i class="fe-x me-1"></i> إلغاء </button>
                                </div>
                            </div>
                            <!-- cta -->
                        </div>
                        <!-- end card-body -->
                 </div>
               <!-- end card-->
            </form>
            <!-- end card-->

        </div>
        <!-- end col-->
    </div>
    <!-- end row-->

@endsection
