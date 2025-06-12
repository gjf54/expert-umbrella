@extends('layouts.layout')


@section('styles')
    <link rel="stylesheet" href="{{ asset("styles/common/categories/index.css") }}">
@endsection


@section('title')
    Категории
@endsection 


@section('content')
    <div class="categories">
        @foreach ($categories as $category)
            <div class="categories__element">
                <a class="categories__link" href="{{ route('categories.show', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
            </div>                
        @endforeach
    </div>
@endsection

