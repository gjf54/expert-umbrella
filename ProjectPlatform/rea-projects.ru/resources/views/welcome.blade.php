@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/welcome.css') }}">
@endsection

@section('title')
РЭУ - проекты
@endsection

@section('content')
    <div class="header d-flex justify-content-center align-items-center flex-column">
        <span class="header_title">РЭУ - <span>Проекты</span></span>
        <span class="header_text">Загружайте Ваши презентации и проекты на единую платформу!</span>
    </div>
    <img src="{{ asset('imgs/welcome/underheader.png') }}" id="underheader">
@endsection