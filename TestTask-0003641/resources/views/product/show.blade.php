@extends('layouts.layout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/common/products/show.css') }}">
@endsection


@section('title')
    {{ $product->name }}
@endsection


@section('content')
    <div class="product">
        <span class="product__field product__link" onclick="copy_product_link()">#{{ $product->id }}</span>
        <span class="product__field">Наименование: {{ $product->name }}</span>
        <span class="product__field">Цена: {{ $product->price }} RUB</span>
        
        <div class="product__description">
            <span class="product__field">Описание</span>
            <span class="product__field">{{ $product->description }}</span>
        </div>
        <div class="product__field">
            <a class="btn" href="{{ route('products.edit', ['category_id' => $product->category->id, 'product_id' => $product->id]) }}">Редактировать</a>
        </div>
        <div class="product__field">
            <a class="btn" href="{{ route('products.destroy', ['category_id' => $product->category->id, 'product_id' => $product->id]) }}">Удалить</a>
        </div>

        @if (App\Models\CartProduct::where([
            'product_id' => $product->id,
            'cart_id' => App\Models\Cart::all()->first()->id,
        ])->first() == null)

            <div class="product__field">
                <div style="width: 130px;" id="add_to_cart" class="btn" onclick="set_element('<?= route('cartProducts.set', ['product_id' => $product->id]) ?>', {{ $product->id }})">В корзину</div>
            </div>    

        @endif
        
    </div>
@endsection

@section('scripts')
    <script>
        function copy_product_link() {  
            navigator.clipboard.writeText("{{ route('products.show', ['category_id' => $product->category->id, 'product_id' => $product->id]) }}")
            alert("Ссылка скопирована!")
        }
    </script>
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection