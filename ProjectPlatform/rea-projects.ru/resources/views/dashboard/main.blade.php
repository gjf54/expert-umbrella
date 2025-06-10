@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/main.css') }}">
@endsection

@section('title')
Панель управления
@endsection

@section('content')
<div class="header d-flex flex-column justify-content-start align-items-center">
    <div class="header_content d-flex flex-column justify-content-center align-items-center">
        <img src="{{ asset('imgs/dashboard/main.jpg') }}" alt="Header image">
        <span>Панель управления портала Rea-Projects</span>
    </div>
</div>
@endsection