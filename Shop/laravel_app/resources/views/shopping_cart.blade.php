@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/shopping_cart.css') }}">
@endsection

@section('title')
Корзина
@endsection

@section('content')
<div class="confirmation_window">
        <span>Вы уверены в том, что хотите оставить заказ?</span>
        <div>
            <button id="unconfirm_button" class="btn btn-outline-danger">Нет</button>
            <button id="confirm_button" class="btn btn-success">Да</a>
        </div>
    </div>
<div class="products">
    @foreach($collection as $element)
    <?php $product = App\Models\Product::find($element->product_id) ?>
    <div class="product d-flex justify-content-between align-items-center" id="<?= 'element-' . $element->id?>">
        <a href="{{ route('catalog_product_view', ['id_category' => App\Models\Product::find(['id' => $element->product_id])->first()->category->id, 'id_product' => $element->product_id]) }}" class="flex flex-row">
            <div class="product_info d-flex flex-row">
                <img src="{{ Storage::url($product->image) }}" alt="">
                <div class="d-flex flex-column">
                    <span role="name">{{ $product->name }}</span>
                    <span role="price" id="<?= "price-product-" . $element->id?>"><span role="price_real">{{ $product->price }}</span> x <span role="product_amount">{{ $element->amount }}</span> = <span role="price_result">{{ $product->price * $element->amount }}</span></span>
                </div>
            </div>    
        </a>    
        <div class="product_control_buttons d-flex flex-row justify-content-center align-items-center">
            <div class="plus_button" onclick="add_amount('<?= route('cart_add_amount', ['id' => $product->id]) ?>')"></div>
            <span id="<?= 'amount-' . $product->id ?>" class="d-flex justify-content-center align-items-center">{{ $element->amount }}</span>
            <div class="minus_button" onclick="rem_amount('<?= route('cart_rem_amount', ['id' => $product->id]) ?>')" ></div>
            <div class="remove_button" onclick="rem_element('<?= route('cart_rem_element', ['id' => $element->id]) ?>')"></div>
        </div>
    </div>
    @endforeach
    <div class="empty_products" style="display: none;">
            <img src="{{ asset('storage/imgs/ui/empty.png') }}" alt="">
            <span>Здесь пока ничего нет</span>
    </div>
    @if($collection->first())
        <button id="order_button" class="btn btn-success" onclick="confirm_order()">Подтвердить заказ</a>
    @else 
        <script>
            window.onload = () => {  
                let orders = $('.products')
                let empty = $('.empty_products')
                orders.addClass('void_products')
                empty.css('display', 'flex')
            }
        </script>
    @endif

</div>

@endsection

@section('scripts')
<script>
    let order_url = "{{ route('cart_make_order') }}"
</script>
<script src="{{ asset('js/shopping_cart.js') }}"></script>
@endsection