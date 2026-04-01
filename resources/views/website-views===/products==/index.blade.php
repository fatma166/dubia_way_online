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
    <div class="row" id="product-scroll-container" style="max-height: 250vh; overflow-y: auto;">
        <div class="content-area shop-grid-content full-width col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="site-main">
                <h3 class="custom_blog_title">
                    {{__('Grid Products')}}
                </h3>
                <div class="shop-top-control">
                    <!--<form class="select-item select-form">
                        <span class="title">{{__('Sort')}}</span>
                        <select title="sort" data-placeholder="9 Products/Page" class="chosen-select">
                            <option value="2">9 Products/Page</option>
                            <option value="1">12 Products/Page</option>
                            <option value="3">10 Products/Page</option>
                            <option value="4">8 Products/Page</option>
                            <option value="5">6 Products/Page</option>
                        </select>
                    </form>-->
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
                        <div class="inner">
                            <a href="{{route('products.list')}}" class="modes-mode mode-list">
                                <span></span>
                                <span></span>
                            </a>
                            <a href="{{route('products.list')}}" class="modes-mode mode-grid  active">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>


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
  <div id="load-more-wrapper" class="text-center mt-4 d-none d-md-block">
    <button id="load-more-button" class="btn btn-primary">{{ __('Load More') }}</button>
</div>


<div id="loading" style="display: none; text-align:center; margin-top: 10px; width: 12rem; margin-right: auto; margin-left: auto;">
    <img src="{{ asset('website/assets/images/orange_circles.gif') }}" alt="Loading..." />
</div>

<!--{!! $products->appends(request()->query())->links('layouts.website.pagination.custom') !!}-->
    </div>
    </div>
<style>
@media (max-width: 767.98px) {
    #load-more-wrapper {
        display: none !important;
    }
}
</style>

@endsection('content')
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
/*let page = 2;
let loading = false;
let hasMore = true;

const container = document.getElementById('product-scroll-container');

container.addEventListener('scroll', function () {
    if (loading || !hasMore) return;

    const scrollBottom = container.scrollTop + container.clientHeight;
    const containerHeight = container.scrollHeight;

    // Trigger load when 200px near the bottom
    if (scrollBottom + 200 >= containerHeight) {
        loadMoreProducts();
    }
});

function loadMoreProducts() {
    loading = true;
    document.getElementById('loading').style.display = 'block';

    const url = `{{ route('products.list') }}?page=${page}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}`;

    fetch(url)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newProducts = doc.querySelectorAll('.product-item');

            if (newProducts.length > 0) {
                newProducts.forEach(el => {
                    container.querySelector('.list-products').appendChild(el);
                });
                page++;
            } else {
                hasMore = false;
            }

            loading = false;
            document.getElementById('loading').style.display = 'none';
        })
        .catch(error => {
            console.error("Load error:", error);
            loading = false;
            document.getElementById('loading').style.display = 'none';
        });
}*/
</script>
<script>
let page = 2;
let loading = false;
let hasMore = true;

const container = document.getElementById('product-scroll-container');

/*function loadMoreProducts() {
    if (loading || !hasMore) return;

    loading = true;
    document.getElementById('loading').style.display = 'block';

    const url = `{{ route('products.list') }}?page=${page}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}`;

    fetch(url)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newProducts = doc.querySelectorAll('.product-item');

            if (newProducts.length > 0) {
                newProducts.forEach(el => {
                    container.querySelector('.list-products').appendChild(el);
                });
                page++;
            } else {
                hasMore = false;
                document.getElementById('load-more-wrapper')?.remove();
            }

            loading = false;
            document.getElementById('loading').style.display = 'none';
        })
        .catch(error => {
            console.error("Error loading products:", error);
            loading = false;
            document.getElementById('loading').style.display = 'none';
        });
}*/

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
                newProducts.forEach(el => {
                    container.querySelector('.list-products').appendChild(el);
                });
                page++;
            } else {
                hasMore = false;
                document.getElementById('load-more-wrapper')?.remove();
            }

            loading = false;
            document.getElementById('loading').style.display = 'none';
        })
        .catch(error => {
            console.error("Error loading products:", error);
            loading = false;
            document.getElementById('loading').style.display = 'none';
        });
}

</script>
<script>
/*if (window.innerWidth <= 768) {
    container.addEventListener('scroll', function () {
        const scrollBottom = container.scrollTop + container.clientHeight;
        const containerHeight = container.scrollHeight;


        if (scrollBottom + 200 >= containerHeight) {
            loadMoreProducts();
        }
    });
}*/

if (window.innerWidth <= 768) {
    function checkScrollBottom() {
        const scrollBottom = container.scrollTop + container.clientHeight;
        const containerHeight = container.scrollHeight;

        if (scrollBottom + 200 >= containerHeight) {
            loadMoreProducts();
        }
    }

    container.addEventListener('scroll', checkScrollBottom);

    // ? Run check immediately on page load
    checkScrollBottom();
}

</script>
<script>
document.getElementById('load-more-button')?.addEventListener('click', function () {
    loadMoreProducts();
});
</script>

@endpush