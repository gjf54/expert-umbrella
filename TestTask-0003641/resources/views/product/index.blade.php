@extends('layouts.layout')


@section('styles')
    <link rel="stylesheet" href="{{ asset("styles/common/products/index.css") }}">
@endsection


@section('title')
    @isset($category)
        {{ 'Категория - ' . $category->name }}
    @else
        {{ sprintf('Продукты (%d)', $products->count()) }}
    @endisset
@endsection


@section('content')
    <div class="products">
        <div class="products__element">
            <a href="{{ route('products.create') }}" class="products__link">Создать новый продукт</a>
        </div>
        @foreach ($products as $product)
            <div class="products__element">
                @php
                    $category = $product->category
                @endphp

                <a class="products__link" href="{{ route('products.show', ['category_id' => $category->id, 'product_id' => $product->id]) }}">
                    {{ $product->name }}
                </a>

                <div class="products__description">
                    <span>Цена: <span style="color:green;">{{ $product->price }}</span> RUB</span>
                    <a href="{{ route('categories.show', ['category_id' => $category->id]) }}">{{ sprintf('Категория: %s', $category->name) }}</a>
                </div>        
            </div>                
        @endforeach
    </div>    
@endsection
