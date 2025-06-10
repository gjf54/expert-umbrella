@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/moderation/ban_form.css') }}">
@endsection

@section('title')
    Блокировка пользователя
@endsection

@section('content')
    <form action="{{ route('dashboard_moderation_ban_user') }}" method="POST" autocomplete="off">
        @csrf

        <div class="input-group">
            <span class="input-group-text">@</span>
            <div class="form-floating is-invalid">
                <input type="text" class="form-control" id="floatingInputGroup2" placeholder="Логин" name="login" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')" required>
                <label for="floatingInputGroup2">Логин</label>
            </div>
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Какие правила нарушил пользователь" id="floatingTextarea" name="reason"></textarea>
            <label for="floatingTextarea">Причина</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password" required>
            <label for="floatingPassword">Пароль</label>
        </div>
        <input type="submit" class="btn btn-danger" value="Выдать блокировку" id="form_button">
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
    </form>
@endsection