@extends('layouts.main_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/auth/auth.css') }}">
@endsection 

@section('title')
    Изменение имени 
@endsection

@section('content')
    <form action="{{ route('profile_name_edit') }}" method="POST">
        @csrf
        
        <div class="form-floating">
            <input type="text" class="form-control" placeholder="Пароль" name="name">
            <label for="floatingPassword">Имя</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" placeholder="Пароль" name="last_name">
            <label for="floatingPassword">Фамилия/Отчество</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password">
            <label for="floatingPassword">Пароль</label>
        </div>
        <input type="submit" class="btn btn-primary" value="Сохранить" id="form_button">
    </form>
@endsection