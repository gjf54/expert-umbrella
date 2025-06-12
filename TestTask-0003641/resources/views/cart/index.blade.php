@extends('layouts.layout')


@section('styles')
    <link rel="stylesheet" href="{{ asset("styles/common/carts/index.css") }}">
@endsection


@section('title')
    Корзина
@endsection


@section('content')
    <div class="header">
        <span class="header__title">Состав корзины</span>
        <a class="header__button btn" href="{{ route('orders.create') }}">Создать заказ</a> 
    </div>

    <div class="products">
        @foreach ($cart->notes as $note)
            <div class="products__element" id="{{ $note->id }}">
                @php
                    $product = $note->product;
                    $category = $product->category;
                @endphp

                <a class="products__link" href="{{ route('products.show', ['category_id' => $category->id, 'product_id' => $product->id]) }}">
                    {{ $product->name }}
                </a>

                <div class="products__description">
                    <span>Цена: <span id="{{ $product->id . '-total-price' }}" style="color:green;">{{ $product->price * $note->amount }}</span> RUB = <span id="{{ $product->id . '-price' }}" style="color:green;">{{ $product->price}}</span> * <span id="{{ $product->id . '-amount' }}" style="color:green;">{{$note->amount}}</span></span>
                </div>
                
                <div class="products__controls">
                    <div class="btn" onclick="add_amount('<?= route('cartProducts.add', ['product_id' => $product->id]) ?>', {{ $product->id }})">+</div>
                    <div class="btn" onclick="rem_amount('<?= route('cartProducts.remove', ['product_id' => $product->id]) ?>', {{ $product->id }})">-</div>
                    <div class="btn" onclick="rem_element('<?= route('cartProducts.delete', ['product_id' => $product->id]) ?>', {{ $product->id }})">Удалить</div>
                </div>
            </div>                
        @endforeach
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>    
@endsection