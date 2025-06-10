@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/projects/project_view.css') }}">
@endsection

@section('title')
{{ 'Проект #' . $project->id }}
@endsection

@section('content')
<iframe src=<?='https://view.officeapps.live.com/op/embed.aspx?src=' . $project_url?> frameborder='0'>
</iframe>
@endsection