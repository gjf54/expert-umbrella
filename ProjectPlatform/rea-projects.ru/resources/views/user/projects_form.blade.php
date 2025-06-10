@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('/styles/user/projects_form.css') }}">
@endsection

@section('title')
Загрузить проект
@endsection

@section('content')
<form action="{{ route('project_upload') }}" method="POST" enctype="multipart/form-data" >
    @csrf

    <div class="mb-3">
        <label for="project_file" class="form-label">Загрузите файл вашего проекта</label>
         <input class="form-control" type="file" id="project_file" name="project_file" accept=" .pptx, .docx, .xlsx, .doc, .pdf" required>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" name="project_name">
        <label for="floatingPassword">Название проекта</label>
    </div>
    <div class="form-floating">
        <textarea class="form-control" placeholder="Расскажите про свой проект" id="floatingTextarea" name="project_description"></textarea>
        <label for="floatingTextarea">Описание</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="mode" id="mode_private" value="private" checked>
        <label class="form-check-label" for="mode_private">
            Приватный
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="mode" id="mode_public" value="public">
        <label class="form-check-label" for="mode_public">
            Публичный
        </label>
    </div>
    @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
        @foreach($errors as $error) 
            <span>{{ $error }}</span>
        @endforeach
    @endif
    <input type="submit" value="Опубликовать" id="form_button" class="btn btn-primary">
</form>
@endsection