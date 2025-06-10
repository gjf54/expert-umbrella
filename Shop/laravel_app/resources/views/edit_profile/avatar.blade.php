@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/edit_profile.css') }}">
<link rel="stylesheet" href="{{ asset('styles/special_styles/edit_profile/avatar.css') }}">
@endsection

@section('title')
Edit Avatar
@endsection

@section('content')
<div class="form">
    <form action="{{ route('fresh_profile_avatar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 d-flex flex-column">
            <label for="avatar">Click to select avatar image...</label>
            <input type="file" name="avatar" id="avatar">
            <span id="selected_file"></span>
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

@section('scripts')
<script src="{{ asset('js/edit_profile/avatar.js') }}"></script>
@endsection
