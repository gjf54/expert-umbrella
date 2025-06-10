@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/users/add_role_to_user_form.css') }}">
@endsection

@section('title')
    @php($page_title = 'Add role to user')
    {{ $page_title }}
@endsection

@section('content')
<div class="form">
    <form action="{{ route('dashboard_set_role_to_user', ['role' => $role]) }}" method="POST">
        @csrf
        <div class="mb-3 d-flex flex-column">
            <label for="login" class="form-label">Введите логин пользователя (без '@')</label>
            <input type="text" name="login" class="form-control typeahead" data-provide="typeahead">
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
    get_logins_url = "{{ route('get_all_logins') }}"
</script>

<script src="{{ asset('js/dashboard/users/add_role_to_user_form.js') }}"></script>
@endsection