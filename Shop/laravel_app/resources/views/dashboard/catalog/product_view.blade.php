@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/catalog/product_view.css') }}">
@endsection

@section('title')
    @php($page_title = $product->name)
    {{ $page_title }}
@endsection

@section('content')
<div class="row d-flex justify-content-start main">
    <div class="image col-md-4 col-sm-12 d-flex">
        <img src="{{ asset(Storage::url($product->image)) }}" alt="product img">
        <a href="#" class="btn btn-primary disabled">В корзину</a>
    </div>
    <div class="info col-md-4 col-sm-12 d-flex flex-column">
        <div class="">
            <div class="info_el d-flex flex-column">
                <span role="title">Название:</span>
                <span role="name">{{ $product->name }}</span>
            </div>
            <div class="info_el d-flex flex-column">
                <span role="title">Цена:</span>
                <span role="price">{{ "$".$product->price }}</span>
            </div>
        </div>
        <div class="info_description d-flex flex-column">
            <span role="title">Описание</span>
            <span><?= $product->description == '' ? '...' : $product->description ?></span>
        </div>
        <a href="{{ route('dashboard_edit_product', ['id_category' => $product->category_id, 'id_product' => $product->id]) }}" class="btn btn-primary info_edit">Редактировать</a>
    </div>
</div>
@endsection