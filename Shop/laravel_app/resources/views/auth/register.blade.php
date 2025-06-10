@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('/styles/auth.css') }}">
@endsection()

@section('title')
Register
@endsection()

@section('content')
<div class="form">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3 d-flex flex-column">
            <label for="name" class="form-label">Name</label> 
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" name="surname" class="form-control">
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="login" class="form-label">Login</label> 
            <input type="text" name="login" class="form-control">
            <div class="form-text">
                Login will not be changeable!
            </div>
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="email" class="form-label">E-Mail</label> 
            <input type="text" name="email" class="form-control">
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
        <button type="submit" class="btn btn-primary">Sign Up</button>
        <a href="/login">Already have account? Log In</a>        
    </form>
</div>
@endsection()