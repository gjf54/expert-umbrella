@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/catalog/products_form.css') }}">
@endsection

@section('title')
    @if($status == 'create')
        @php($page_title = 'Create product')
    @else
        @php($page_title = 'Edit product')
    @endif
    {{ $page_title }}
@endsection

@section('content')
<div class="form">
    <form action="<?= $status == 'create' ? route('dashboard_send_created_product', ['id' => $category->id]) : route('dashboard_save_edited_product', ['id_category' => $category->id, 'id_product' => $product->id]) ?>" method="POST">
        @csrf
        <div class="mb-3 d-flex flex-column mb-3">
            <label for="name" class="form-label">Название продукта</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= $status == 'edit' ? $product->name : '' ?>">
        </div>
        <div class="mb-3 d-flex flex-column mb-3">
            <label for="price" class="form-label">Цена</label>
            <input type="text" name="price" id="price" class="form-control" value="<?= $status == 'edit' ? $product->price : '' ?>">
        </div>
        <div class="mb-3 d-flex flex-column mb-3">
            <label for="description" class="form-label">Описание (опционально)</label>
            <textarea type="text" name="description" id="description" class="form-control"><?= $status == 'edit' ? $product->description : '' ?></textarea>
        </div>
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
        <button type="submit" class="btn btn-primary">
            @if($status == 'create')
                Создать
            @else
                Сохранить изменения
            @endif
        </button>
    </form>
</div>
@endsection