@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/auth/auth.css') }}">
@endsection 

@section('title')
    Изменение пароля
@endsection

@section('content')
    <form action="{{ route('profile_password_edit') }}" method="POST">
        @csrf

        <div class="form-floating">
            <input type="password" class="form-control" placeholder="Пароль" name="new_password">
            <label for="floatingPassword">Новый пароль</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" placeholder="Пароль" name="new_password_repeat">
            <label for="floatingPassword">Повторите новый пароль</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password">
            <label for="floatingPassword">Старый пароль</label>
        </div>
        <input type="submit" class="btn btn-primary" value="Сохранить" id="form_button">
    </form>
@endsection