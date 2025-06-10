@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/errors/uni_error.css') }}">
@endsection

@section('title')
Страница не найдена
@endsection

@section('content')
<div class="error">
    <span role="error">Этой страницы не существует!</span>
    <span role="error_code">#404</span>
    <img src="{{ asset('storage/imgs/ui/error.png') }}" alt="">
    <a href="/">На главную</a>
</div>
@endsection