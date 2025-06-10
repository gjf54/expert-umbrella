@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/moderation/main.css') }}">
@endsection

@section('title')
Модерация
@endsection

@section('content')
<div class="moderation_menu row">
    <div class="moderation_menu_item col-md-3">
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{ route('dashboard_moderation_bans') }}">Блокировки</a>
        </div>
    </div>
    <div class="moderation_menu_item col-md-3">
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{ route('moderation_reports') }}">Жалобы</a>
        </div>
    </div>
</div>
@endsection