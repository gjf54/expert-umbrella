@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/edit_profile.css') }}">
@endsection

@section('title')
Edit Profile
@endsection

@section('content')
<div class="form">
    <form action="{{ route('fresh_profile_email') }}" method="POST">
        @csrf
        <span>Your current E-Mail: {{ $user->email }}</span>
        <div class="mb-3 d-flex flex-column">
            <label for="email" class="form-label">New Email</label>
            <input type="text" name="email" class="form-control">
        </div>
        <div class="mb-3 d-flex flex-column">
            <label for="confirm_new_password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
            <div class="form-text">Enter your current password to confirm changes</div>
        </div>
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
        @if(session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>
<hr>
@endsection