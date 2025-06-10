@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/users/roles_form.css') }}">
@endsection

@section('title')
    Выдать роль 
@endsection

@section('content')
<div class="form">
    <form action="{{ route('dashboard_users_grant_role', ['role' => $role]) }}" method="POST" autocomplete="off">
        @csrf

        <div class="input-group">
            <span class="input-group-text">@</span>
            <div class="form-floating is-invalid">
                <input type="text" class="form-control typeahead" id="floatingInputGroup2" placeholder="Логин пользователя" name="selected_login" data-provide="typeahead" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')" required>
                <label for="floatingInputGroup2">Логин</label>
            </div>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password">
            <label for="floatingPassword">Пароль</label>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <button type="submit" class="btn btn-outline-success">Выдать роль</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    get_logins_url = "{{ route('data_get_logins') }}"
</script>

<script src="{{ asset('js/dashboard/users/search_login.js') }}"></script>
@endsection