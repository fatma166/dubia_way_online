@if(session('cart') && count(session('cart')) > 0)
    @foreach(session('cart') as $id => $item)
        <div class="side-cart-item" data-id="{{ $id }}">
            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
            <div class="side-cart-item-details">
                <p class="product-name">{{ $item['name'] }}</p>
                <p class="quantity-price">{{ $item['quantity'] }} x {{ $item['price'] . ' ' . config('app.currency') }}</p>
                {{-- يمكنك إضافة زر حذف هنا لاحقاً --}}
            </div>
        </div>
    @endforeach
@else
    <p class="text-center p-4">{{ __('Your cart is empty.') }}</p>
@endif