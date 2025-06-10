@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/catalog/category_form.css') }}">
@endsection

@section('title')
    @if($status == 'create')
        @php($page_title = 'Create category')
    @else
        @php($page_title = 'Edit category')
    @endif
    {{ $page_title }}
@endsection

@section('content')
<div class="form">
    <form action="<?= $status == 'create' ? route('dashboard_send_created_category') : route('dashboard_save_edited_category', ['id' => $category->id]) ?>" method="POST">
        @csrf
        <div class="mb-3 d-flex flex-column">
            <label for="name" class="form-label">Название категории</label>
            <input type="text" class="form-control" name="name" value="<?= $status == 'edit' ? $category->name : '' ?>">
        </div>
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
        @endforeach
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div> 
        @endif
        <button type="submit" class="btn btn-primary">
            @if($status == 'create')
                Создать
            @else
                Сохранить
            @endif
        </button>
    </form>
</div>
@endsection