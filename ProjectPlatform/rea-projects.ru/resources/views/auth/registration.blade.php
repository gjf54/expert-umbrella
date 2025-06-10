@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/auth/auth.css') }}">
@endsection

@section('title')
    Регистрация
@endsection

@section('content')
    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="input-group">
            <span class="input-group-text">@</span>
            <div class="form-floating is-invalid">
                <input type="text" class="form-control" id="floatingInputGroup2" placeholder="Логин" name="login" required>
                <label for="floatingInputGroup2">Логин</label>
            </div>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password" required>
            <label for="floatingPassword">Пароль</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword2" placeholder="Пароль" name="password_repeat" required>
            <label for="floatingPassword">Повторите пароль</label>
        </div>
        <div class="input-group">
            <span class="input-group-text">#</span>
            <div class="form-floating is-invalid">
                <input type="text" class="form-control" id="floatingInputGroup3" placeholder="Токен" name="token" required>
                <label for="floatingInputGroup2">Токен</label>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Зарегистрироваться" id="form_button">
        <a href="{{ route('login_page') }}">Уже есть аккаунт? Войти</a>
    </form>
@endsection