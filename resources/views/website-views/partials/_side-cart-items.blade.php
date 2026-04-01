{{-- CSS بسيط لتنسيق العناصر داخل القائمة --}}
<style>
    .drawer-cart-item { display: flex; align-items: center; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f0f0f0; }
    .drawer-cart-item:last-child { border-bottom: none; margin-bottom: 0; }
    .drawer-cart-item .item-img { width: 70px; height: 70px; object-fit: cover; border-radius: 5px; margin-left: 15px; }
    .drawer-cart-item .item-details { flex: 1; }
    .drawer-cart-item .item-details .product-name { font-weight: 700; font-size: 16px; margin-bottom: 8px; display: block; color: #333; line-height: 1.4; }
    .drawer-cart-item .item-details .product-name:hover { color: #dca716; }
    .drawer-cart-item .item-price { font-size: 16px; font-weight: 600; color: #555; }
    .drawer-cart-item .remove-btn { color: #ff4d4d; font-size: 18px; }
    .drawer-cart-item .remove-btn:hover { color: #d90429; }
</style>

@if(isset($cart) && count($cart) > 0)
    @foreach($cart as $key => $cartItem)
        <div class="drawer-cart-item">
            <a href="{{route('products.details', $cartItem['id'])}}">
                <img class="item-img"
                     src="{{asset($cartItem['thumbnail'])}}"
                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                     alt="Product">
            </a>
            <div class="item-details">
                <a href="{{route('products.details', $cartItem['id'])}}" class="product-name text-truncate">
                    {{$cartItem['name']}}
                </a>
                <div class="item-price">
                    <span>{{ $cartItem['price'] . ' ' . config('app.currency') }}</span>
                    <span>&times;</span>
                    <span>{{$cartItem['quantity']}}</span>
                </div>
            </div>
            {{-- زر الحذف. تأكد من وجود دالة removeFromCart في JS --}}
           <a href="javascript:void(0);" onclick="removeFromCart('{{ $cartItem['key'] }}')" class="remove-btn">
                <i class="czi-close-circle"></i>
            </a>
        </div>
    @endforeach
@else
    <div class="text-center p-4">
        <i class="czi-cart" style="font-size: 3rem; color: #ddd;"></i>
        <p class="mt-3 text-muted">{{__('Your cart is empty.')}}</p>
    </div>
@endif