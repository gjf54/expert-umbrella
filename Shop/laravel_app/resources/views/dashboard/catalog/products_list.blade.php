@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/catalog/products_list.css') }}">
@endsection

@section('title')
    @php($page_title = 'Products list')
@endsection

@section('content')
@foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
@endforeach
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<div class="products row g-4">
    <div class="add_product col-xl-4 col-md-6">
        <a href="{{ route('dashboard_create_product', ['id' => $category->id]) }}">Добавить продукт</a>
    </div>
    @foreach($products as $product)
        <div class="product col-xl-4 col-md-6">
            <div class="buttons">
                <a href="<?= route('dashboard_edit_product', ['id_category' => $category->id, 'id_product' => $product->id]) ?>" class="btn btn-primary">Ред.</a>
                <a href="{{ route('dashboard_product_delete', ['id_category' => $category->id, 'id_product' => $product->id]) }}" class="btn btn-danger">Удалить</a>
            </div>
            <a href="{{ route('dashboard_product_view', ['id_category' => $category->id, 'id_product' => $product->id]) }}">
                <img src="{{ asset(Storage::url($product->image)) }}" alt="product img">
                <?php 
                    $curr_name = $product->name;
                    $max_size = 26;
                    if (strlen($curr_name) > $max_size) {
                        $curr_name = str_split($curr_name, $max_size - 3);
                        echo '<span role="name">' . $curr_name[0] . '...' .'</span>';
                    } else {
                        echo '<span role="name">' . $product->name . '</span>';
                    }
                ?>
                <span role="price">{{ "$".$product->price }}</span>
            </a>
        </div>
    @endforeach
</div>
@endsection