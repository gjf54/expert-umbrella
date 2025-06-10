@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/auth/auth.css') }}">
@endsection

@section('title')
Войти
@endsection

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        
        <div class="input-group">
            <span class="input-group-text">@</span>
            <div class="form-floating is-invalid">
                <input type="text" class="form-control" id="floatingInputGroup2" placeholder="Логин" name="login" required>
                <label for="floatingInputGroup2">Логин</label>
            </div>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password">
            <label for="floatingPassword">Пароль</label>
        </div>
        <input type="submit" class="btn btn-primary" value="Войти" id="form_button">
        <a href="{{ route('registration_page') }}">Нет аккаунта? Зарегистрироваться</a>
    </form>
@endsection