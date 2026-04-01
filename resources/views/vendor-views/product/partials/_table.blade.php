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
            <th>اسم المنتج</th>
            <th>التصنيف</th>
            <th>السعر</th>
            <th>المخزون</th>
            <th>تاريخ إنشاء</th>
            <th>الحالة</th>
            <th>تمييز</th>
            <th style="width: 85px;">الإجراء</th>
        </tr>
        </thead>
        <tbody>
        @if($products->count()>0)
            @foreach($products as $product)
                <tr>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheck{{$product->id}}">
                            <label class="form-check-label" for="customCheck2">&nbsp;</label>
                        </div>
                    </td>
                    <td class="table-user">
                        <img src="{{asset($product->image)}}" alt="table-user" class="me-2 rounded-circle" onerror="this.src='{{asset('assets/images/avatar.svg')}}'">
                        <a href="javascript:void(0);" class="text-body fw-semibold">{{$product->name}}</a>
                    </td>
                    <td> {{$product->category}}</td>
                    <td> {{$product->price}} {{__(config('app.currency'))}} </td>
                    <td><span class="badge bg-soft-success text-success">@if($product->in_stock==1)متوفر @else غير متوفر@endif</span></td>
                    <td> منذ{{\Carbon\Carbon::parse($product->creared_at)->translatedFormat('l j F Y')}} <br>الساعة منذ{{\Carbon\Carbon::parse($product->creared_at)->translatedFormat('H:i:s')}} </td>

                    <td>
                        <span class="badge bg-soft-success text-success">منشور @if($product->status==1)@elseغير منشور@endif </span>
                    </td>
                    <td>
                        <a  href="{{route('vendor.product.fav-status',['id'=>$product->id,'status'=>$product->favourite])}}">
                            @if($product->favourite==1)
                                <i class="mdi mdi-star" ></i>
                            @endif
                            @if($product->favourite==0)
                                <i class="mdi mdi-star-outline" ></i>
                            @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{route('vendor.product.edit',['id'=>$product->id])}}" class="action-icon">
                            <i class="mdi mdi-eye"></i>
                        </a>
                        <a href="{{route('vendor.product.edit',['id'=>$product->id])}}" class="action-icon">
                            <i class="mdi mdi-square-edit-outline"></i>
                        </a>
                        <a data-bs-toggle="modal" href="#exampleModalToggle" role="button" class="action-icon" delete-id={{$product->id}} >
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
        {!! $products->withQueryString()->links() !!}
    </div>
@endif