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
                            <span></span>
                            <span></span>
                        </a>
                        <a href="{{route('products.list')}}" class="modes-mode mode-grid active">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
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

    <div id="load-more-wrapper" class="text-center mt-4 d-none d-md-block">
        <button id="load-more-button" style="background: #bfa15a; color: #fff; border-radius: 24px; box-shadow: 0 2px 8px #bfa15a33; border: none; padding: 12px 36px; font-weight: bold; font-size: 1.1rem; transition: background 0.2s, color 0.2s;">{{ __('Load More') }}</button>
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
.breadcrumb-trail {
    width: 105%;
    margin-left: -2.5%;
}
.shop-top-control {
    background: #f5e7c3;
    border-radius: 12px;
    box-shadow: 0 2px 12px #bfa15a22;
    padding: 16px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 24px;
    min-height: 70px;
    width: 105%;
    margin-left: -2.5%;
}
.filter-choice {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}
.filter-choice .title {
    font-weight: bold;
    color: #bfa15a;
    font-size: 1.1rem;
}
.filter-choice select.chosen-select {
    border-radius: 8px;
    border: 1px solid #bfa15a;
    padding: 8px 12px;
    font-size: 1rem;
    min-width: 150px;
    background-color: #fff;
}
.grid-view-mode {
    display: flex;
    gap: 14px;
}
.modes-mode {
    border-radius: 8px;
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s;
}
.modes-mode.mode-list {
    background: #f7f7f7;
}
.modes-mode.mode-grid.active {
    background: #bfa15a;
}
.modes-mode:not(.active):hover {
    background: #e9dcb9;
}
.list-products {
    overflow-x: hidden !important;
}
.product-item {
    border-radius: 12px;
    box-shadow: 0 2px 8px #bfa15a22;
    background: #fff;
    margin-bottom: 18px;
    transition: box-shadow 0.2s;
}
.product-item:hover {
    box-shadow: 0 4px 16px #bfa15a33;
}
#load-more-button:hover {
    background: #232323;
    color: #bfa15a;
}
.modes-mode span {
    display: inline-block;
    width: 30px;
    height: 30px;
    border-radius: 5px;
}
.modes-mode.mode-list span:first-child {
    background: #bfa15a;
}
.modes-mode.mode-list span:last-child {
    background: #fff;
}
.modes-mode.mode-grid.active span {
    background: #fff;
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
// Infinite scroll for mobile devices
if (window.innerWidth < 768) {
    const handleInfiniteScroll = () => {
        // The 'loading' and 'hasMore' flags are managed in the loadMoreProducts function
        if (loading || !hasMore) {
            return;
        }

        // Check if the user is near the bottom of the page (500px buffer)
        const nearBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500;

        if (nearBottom) {
            loadMoreProducts();
        }
    };

    window.addEventListener('scroll', handleInfiniteScroll);

    // Initial check in case the page content is not tall enough to scroll at first
    document.addEventListener('DOMContentLoaded', () => {
        // A small delay can help ensure the initial layout is calculated correctly
        setTimeout(handleInfiniteScroll, 500);
    });
}

</script>
<script>
document.getElementById('load-more-button')?.addEventListener('click', function () {
    loadMoreProducts();
});
</script>

@endpush