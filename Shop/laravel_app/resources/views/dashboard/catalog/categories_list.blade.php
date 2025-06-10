@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/catalog/categories_list.css') }}">
@endsection

@section('title')
    @php($page_title = 'Edit Catalog')
    {{ $page_title }}
@endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<div class="categories row g-4">
    <div class="add_category col-xl-4 col-md-6">
        <a href="{{ route('dashboard_create_category') }}">Добавить категорию</a>
    </div>
    @foreach($categories as $category)
        <div class="category col-xl-4 col-md-6">
            <div class="buttons">
                <a href="{{ route('dashboard_edit_category', ['id' => $category->id]) }}" class="btn btn-primary">Ред.</a>
                <a href="{{ route('dashboard_category_delete', ['id' => $category->id]) }}" class="btn btn-danger">Удалить</a>
            </div>
            <a href="{{ route('dashboard_category_contains', ['id' => $category->id]) }}">
                <img src="{{ asset(Storage::url($category->image)) }}" alt="">
                <span>{{ $category->name }}</span>
            </a>
        </div>
    @endforeach
</div>
@endsection