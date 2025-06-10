@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/auth/auth.css') }}">
<link rel="stylesheet" href="{{ asset('styles/user/edit/avatar.css') }}">
@endsection 

@section('title')
    Изменение аватара
@endsection

@section('content')
    <form action="{{ route('profile_avatar_edit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 d-flex flex-column">
            <label for="avatar">Нажмите, чтобы выбрать изображение</label>
            <input type="file" name="avatar" id="avatar">
            <span id="selected_file"></span>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password">
            <label for="floatingPassword">Пароль</label>
        </div>
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
        <input type="submit" class="btn btn-primary" value="Сохранить" id="form_button">
    </form>
@endsection

@section('scripts')
<script src="{{ asset('js/avatar_edit.js') }}"></script>
@endsection