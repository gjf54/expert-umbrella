@extends('layouts.dashboard_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/dashboard/tokens/token_form.css') }}">
@endsection 

@section('title')
    Добавить токен
@endsection 

@section('content')
    <form action="{{ route('dashboard_tokens_add_token') }}" method="POST" class="d-flex flex-column justify-content-center" autocomplete="off">
        @csrf

        <div class="input-group">
            <span class="input-group-text">#</span>
            <div class="form-floating is-invalid">
                <input type="text" class="form-control" id="floatingInputGroup2" placeholder="Токен" name="token" readonly onfocus="this.removeAttribute('readonly')" required>
                <label for="floatingInputGroup2">Токен</label>
            </div>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password" required>
            <label for="floatingPassword">Пароль</label>
        </div>
        <input type="submit" class="btn btn-primary" value="Создать токен" id="form_button">
    </form>
@endsection