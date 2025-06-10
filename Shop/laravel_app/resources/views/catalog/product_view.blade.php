@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/catalog/product_view.css') }}">
@endsection

@section('title')
{{ $product->name }}
@endsection

@section('content')
<a href="{{ route('products_in_category', ['id' => $category->id]) }}" class="btn btn-outline-secondary" id="return_back">Return back</a>
<div class="row d-flex justify-content-start main">
    <div class="image col-md-4 col-sm-12 d-flex">
        <img src="{{ asset(Storage::url($product->image)) }}" alt="product img">
        
        @php($flag = true)
        @foreach($collection as $el)
            @if($el->product_id == $product->id)
                @php($flag = false)
                <div id="<?= 'control-' . $product->id ?>" class="product_control_buttons d-flex flex-row justify-content-around align-items-center">
                    <div class="plus_button" onclick="add_amount('<?= route('cart_add_amount', ['id' => $product->id]) ?>')"></div>
                    <span id="<?= 'amount-' . $product->id ?>" class="d-flex justify-content-center align-items-center">{{ $el->amount }}</span>
                    <div class="minus_button" onclick="rem_amount('<?= route('cart_rem_amount', ['id' => $product->id]) ?>')" ></div>
                </div>
                @break
            @endif
        @endforeach

        @if(auth()->user() == null)
            @php($flag = false)
            <a href="{{ route('profile') }}" class="btn btn-primary">В корзину</a>
        @endif

        @if($flag)
            <button id="<?= 'product-' . $product->id ?>" class="btn btn-primary" onclick="set_element('<?= route('cart_set_element', ['id' => $product->id]) ?>')">В корзину</button>
            <div id="<?= 'control-' . $product->id ?>" class="product_control_buttons d-flex flex-row justify-content-around align-items-center" style="display:none !important;">
                <div class="plus_button" onclick="add_amount('<?= route('cart_add_amount', ['id' => $product->id]) ?>')"></div>
                <span id="<?= 'amount-' . $product->id ?>" class="d-flex justify-content-center align-items-center">{{ 1 }}</span>
                <div class="minus_button" onclick="rem_amount('<?= route('cart_rem_amount', ['id' => $product->id]) ?>')" ></div>
            </div>
        @endif
        
    </div>
    <div class="info col-md-4 col-sm-12 d-flex flex-column">
        <div class="">
            <div class="info_el d-flex flex-column">
                <span role="title">Name:</span>
                <span role="name">{{ $product->name }}</span>
            </div>
            <div class="info_el d-flex flex-column">
                <span role="title">Price:</span>
                <span role="price">{{ "$".$product->price }}</span>
            </div>
        </div>
        <div class="info_description d-flex flex-column">
            <span role="title">Description</span>
            <span><?= $product->description == '' ? '...' : $product->description ?></span>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/shopping_cart.js') }}"></script>
@endsection