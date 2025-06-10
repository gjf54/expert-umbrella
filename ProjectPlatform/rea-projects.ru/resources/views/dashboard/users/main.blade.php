@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/users/main.css') }}">
@endsection

@section('title')
    Управление правами доступа
@endsection

@section('content')

@if(session()->has('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        {{ $error }}
    @endforeach
</div>
@endif

<div class="users_list">
    <div class="users_group">
        <div class="header_field">
            <span role="group_title">Супер-администратор</span>
        </div>
        @foreach($super_admins as $super_admin)
            <div class="user_field">
                <span class="user_login" role="super_admin">
                    <?= '@'.$super_admin->login ?>
                </span>
            </div>
        @endforeach
    </div>
    <div class="users_group">
        <div class="header_field">
            <span role="group_title">Администраторы</span>
            @if($user->hasRole('admin') and !($user->hasRole('super_admin')))
                <a href="" class="btn btn-primary disabled" role="button" aria-disabled="true">Добавить</a>
            @else
            <a href="{{ route('dashboard_users_roles_form', ['role' => 'admin']) }}" class="btn btn-primary" role="button">Добавить</a>
            @endif
        </div>
        @foreach($admins as $admin)
            <div class="user_field">
                <span class="user_login" role="admin">
                    <?= '@'.$admin->login ?>
                </span>
                @if($user->hasRole('super_admin'))
                    <div class="user_control_buttons">
                        <a href="{{ route('dashboard_users_remove_role', ['id' => $admin->id, 'role' => 'admin']) }}" class="btn btn-danger">Убрать роль</a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection