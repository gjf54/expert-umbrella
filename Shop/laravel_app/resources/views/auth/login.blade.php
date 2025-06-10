@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('/styles/auth.css') }}">
@endsection()

@section('title')
Login
@endsection()

@section('content')
<div class="form">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3 d-flex flex-column">
            <label for="login" class="form-label">Login</label>
            <input type="text" name="login" class="form-control">
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Sign In</button>
        <a href="/register">Do not have account? Registration</a>
    </form>
</div>

@endsection()