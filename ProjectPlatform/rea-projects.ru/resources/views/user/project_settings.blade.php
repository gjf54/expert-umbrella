@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/user/projects_form.css') }}">
@endsection

@section('title')
Настройка проекта
@endsection

@section('content')
<form action="{{ route('project_settings_apply', ['id' => $project->id]) }}" method="POST">
    @csrf
    
    <div class="form-floating">
        <input type="text" class="form-control" name="name" value="{{ $project->name }}">
        <label for="floatingPassword">Название проекта</label>
    </div>
    <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="description">
            {{ $project->description }}
        </textarea>
        <label for="floatingTextarea">Описание</label>
    </div>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="mode" id="mode_private" value="private" <?= $project->is_private ? 'checked' : '' ?>>
            <label class="form-check-label" for="mode_private">
                Приватный
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="mode" id="mode_public" value="public" <?= $project->is_private ? '' : 'checked' ?>>
            <label class="form-check-label" for="mode_public">
                Публичный
            </label>
        </div>
    </div>
    <input type="submit" value="Сохранить" id="form_button" class="btn btn-primary">
    <a href="{{ route('project_delete', ['id' => $project->id]) }}" style="color:red;margin:auto;margin-top:30px;">Удалить проект</a>
</form>
@endsection