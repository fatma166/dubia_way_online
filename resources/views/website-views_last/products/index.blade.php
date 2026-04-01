@extends('layouts.website.master')
@section('title')
    {{__("Products")}}
@endsection

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-trail breadcrumbs">
                <ul class="trail-items breadcrumb">
                    <li class="trail-item trail-begin">
                        <a href="{{route('home.index')}}">{{__('Home')}}</a>
                    </li>
                    <li class="trail-item trail-end active">
                        {{__('Grid Products')}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row" id="product-scroll-container">
        <div class="content-area shop-grid-content full-width col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="site-main">
                <h3 class="custom_blog_title">
                    {{__('Grid Products')}}
                </h3>
                <div class="shop-top-control">
                    <form class="filter-choice select-form">
                        <span class="title">{{__('Sort by')}}</span>
                        <select title="sort-by" data-placeholder="Price: Low to High" class="chosen-select">
							<option>{{__('--')}}</option>
                            <option value="price_low_to_high">{{__('Price: Low to High')}}</option>
                            <option value="popularity">{{__('Sort by popularity')}}</option>
                            <option value="new">{{__('Sort by newness')}}</option>
                            <option value="price_high_to_low">{{__('Sort by price: high to low')}}</option>
                        </select>
                    </form>
                    <div class="grid-view-mode">
                            <a href="{{route('products.list')}}" class="modes-mode mode-list">
                                <i class="fa fa-th-list"></i>
                            </a>
                            <a href="{{route('products.list')}}" class="modes-mode mode-grid active">
                                <i class="fa fa-th"></i>
                            </a>
                    </div>
                </div>
            </div>
        </div>
        @if (session('message_offer_text'))
    <div class="alert alert-success">
        {{ session('message_offer_text') }}
    </div>
@endif
<!--<ul class="row list-products auto-clear equal-container product-grid">
@include('website-views.products.partails._table')
	</ul>-->


    <ul class="row list-products auto-clear equal-container product-grid">
        @include('website-views.products.partails._table')
    </ul>

    <div id="load-more-wrapper" class="text-center" style="margin: 30px 0;">
        <button id="load-more-button">{{ __('Load More') }}</button>
    </div>


<div id="loading" style="display: none; text-align:center; margin-top: 10px; width: 12rem; margin-right: auto; margin-left: auto;">
    <img src="{{ asset('website/assets/images/orange_circles.gif') }}" alt="Loading..." />
</div>

<!--{!! $products->appends(request()->query())->links('layouts.website.pagination.custom') !!}-->
    </div>
    </div>
<style>
.shop-top-control {
    background: #f5e7c3;
    border-radius: 12px;
    box-shadow: 0 2px 12px #bfa15a22;
    padding: 20px 30px;
    margin: 0 auto 30px auto;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 30px;
    min-height: 80px;
    width: 100%;
}
.filter-choice {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
}
.filter-choice .title {
    font-weight: bold;
    color: #bfa15a;
    font-size: 1.2rem;
}
.filter-choice select.chosen-select {
    border-radius: 8px;
    border: 1px solid #bfa15a;
    padding: 10px 15px;
    font-size: 1.1rem;
    min-width: 180px;
    background-color: #fff;
}
.grid-view-mode {
    display: flex;
    gap: 15px;
}
.modes-mode {
    border-radius: 8px;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background-color 0.3s;
    border: 1px solid #e9dcb9;
}
.modes-mode.mode-list {
    background: #f7f7f7;
}
.modes-mode.mode-grid.active {
    background: #bfa15a;
    border-color: #bfa15a;
}
.modes-mode:not(.active):hover {
    background: #e9dcb9;
}
.modes-mode i {
    font-size: 20px;
    color: #bfa15a;
}
.modes-mode.active i,
.modes-mode:hover i {
    color: #fff;
}
.breadcrumb-trail {
    width: 100%;
}
#load-more-button {
    background: #bfa15a;
    color: #fff;
    border: none;
    padding: 14px 50px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(191, 161, 90, 0.4);
}
#load-more-button:hover {
    background: #a68b4d;
    transform: translateY(-2px);
}
@media (max-width: 767.98px) {
    #load-more-wrapper {
        display: none !important;
    }
}
</style>

@endsection
@push('script')
<script>
	$(".filter-choice select").on("change",function(e){
		e.preventDefault();
          // Get category_id from the current URL
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id');
		//alert($(this).val());
		$.ajax({
                    url: '{{route('products.list')}}',
                    method: 'GET',
                   // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        //count: true, //$('#change_status').attr('status_id')
                        arrange:$(this).val(),
                        category_id: categoryId


                    },
                    success: function(response) {
                        //  console.log(response);
                       // location.reload();
                        // do something with the response data
		            $(".list-products").empty().append(response.products);
                $(".pagination").empty().append(response.pagination);                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        // handle the error case
                    }
                });

	});
</script>
<script>
let page = 2;
let loading = false;
let hasMore = true;

function loadMoreProducts() {
    if (loading || !hasMore) return;

    loading = true;
    document.getElementById('loading').style.display = 'block';

    // Get existing query parameters (like category_id) from URL
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id'); // You can also get brand_id, size, etc.
    const arrange = urlParams.get('arrange'); // Optional: If you want to maintain sorting

    // Build URL with page + optional filters
    let url = `{{ route('products.list') }}?page=${page}`;
    if (categoryId) url += `&category_id=${categoryId}`;
    if (arrange) url += `&arrange=${arrange}`;

    fetch(url)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newProducts = doc.querySelectorAll('.product-item');

            if (newProducts.length > 0) {
                const list = document.querySelector('.list-products');
                newProducts.forEach(el => {
                    list.appendChild(el);
                });
                page++;
            } else {
                hasMore = false;
                const btnWrapper = document.getElementById('load-more-wrapper');
                if(btnWrapper) btnWrapper.remove();
            }
        })
        .catch(error => {
            console.error("Error loading products:", error);
        })
        .finally(() => {
            loading = false;
            document.getElementById('loading').style.display = 'none';
        });
}

// Infinite scroll for mobile, button for desktop
if (window.innerWidth < 768) {
    // Mobile: Infinite Scroll
    window.addEventListener('scroll', () => {
        // Trigger load 600px before reaching the end of the document
        if (!loading && hasMore && (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 600) {
            loadMoreProducts();
        }
    });
} else {
    // Desktop: Load More Button
    const loadMoreBtn = document.getElementById('load-more-button');
    if(loadMoreBtn) {
        loadMoreBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loadMoreProducts();
        });
    }
}
</script>
@endpush