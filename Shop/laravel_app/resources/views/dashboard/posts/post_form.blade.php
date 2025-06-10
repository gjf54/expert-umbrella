@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/posts/post_form.css') }}">
@endsection

@section('title')
    @if($status == 'create')
        @php($page_title = 'Create post')
    @endif

    @if($status == 'edit')
        @php($page_title = 'Edit post')
    @endif

    {{ $page_title }}
@endsection

@section('content')
<div class="form">
    <form action="<?php 
        if($status == 'create'){ 
            echo route('dashboard_send_created_post');
        }else { 
            echo route('dashboard_send_edit_post', ['id' => $post->id]);
        }
        ?>" method="POST">
        @csrf
        <div class="mb-3 d-flex flex-column">
            <label for="title" class="form-label">Название объявления</label>
            <input type="text" name="title" id="title" class="form-control" 
                <?php 
                    if($status == 'edit') {
                        echo 'value="'.$post->title.'"';
                    }
                ?>
            >
        </div>
        <div class="mb-3 d-flex flex-column form-floating">
            <textarea name="text" id="text_of_post" class="form-control">
                <?php 
                    if($status == 'edit') {
                        echo $post->text;
                    }
                ?>
            </textarea>
            <label for="text_of_post" class="form-label">Текст объявления</label>
        </div>
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
        
        @if(session()->has('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <button type="submit" class="btn btn-primary">
            @if($status == 'create')
            Создать 
            @endif
    
            @if($status == 'edit')
            Сохранить изменения
            @endif      
        </button>
    </form>
</div>
@endsection