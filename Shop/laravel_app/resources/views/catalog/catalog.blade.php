@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('/styles/catalog/categories.css') }}" />
@endsection

@section('title')
Каталог
@endsection()

@section('content')
<div class="categories row d-flex col-md-offset-5 justify-content-around">
	<span role="categories_title">Категории</span>
	@foreach($categories as $category)
		<div class="category col-sm-5 col-md-4">
			<a href="{{ route('products_in_category', ['id' => $category->id]) }}" class=" d-flex justify-content-center align-items-center">
				<img src="{{ asset(Storage::url($category->image))}}" alt="category image" />
				<span role="category_name">{{ $category->name }}</span>
			</a>
		</div>
	@endforeach
</div>
@endsection()