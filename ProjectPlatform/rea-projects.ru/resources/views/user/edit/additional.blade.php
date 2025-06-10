@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/auth/auth.css') }}">
<link rel="stylesheet" href="{{ asset('styles/user/edit/add.css') }}">
@endsection 

@section('title')
    Изменение данных 
@endsection

@section('content')
    <form action="{{ route('profile_add_edit') }}" method="POST">
        @csrf
        
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="description"></textarea>
            <label for="floatingTextarea">Описание</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password">
            <label for="floatingPassword">Пароль</label>
        </div>
        @if($errors->first())
            {{ $errors->first() }}
        @endif
        <input type="submit" class="btn btn-primary" value="Сохранить" id="form_button">
    </form>
@endsection