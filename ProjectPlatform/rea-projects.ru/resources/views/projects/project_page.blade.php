@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/projects/project_page.css') }}">
@endsection

@section('title')
Проект {{ '#' . $project->id }}
@endsection

@section('content')
    @php($user = $project->user)
    <div class="alert alert-success" id="success_message" style="margin-top: 20px; display: none;"></div>
    <div class="alert alert-danger" id="fail_message" style="margin-top: 20px; display: none;"></div>
    <div class="project row justify-content-around">
        <div class="project_info col-lg-5">
            <div class="project_view d-flex flex-column align-items-start">
                <a href="{{ route('user_profile_view', ['id' => $user->id]) }}" class="project_view_user d-flex flex-row align-items-center">
                    @if($user->avatar == 'default.png')
                        <img src="{{ asset('imgs/avatar/default.png') }}" alt="avatar">
                    @else
                        <img src="{{ asset('storage/imgs/avatars/' . $user->avatar) }}" alt>
                    @endif
                    <span role="project_user">
                        @if($user->name == null)
                            <?= '@' . $user->login ?>
                        @else
                            <?= $user->name . ' ' . $user->last_name ?>
                        @endif
                    </span>
                </a>
                @if($project->is_private == false)
                <div id="report_form" class="form d-flex justify-content-center align-items-center flex-column">
                    <span>Жалоба на проект #{{ $project->id }}</span>
                    <div class="form-floating"  style="width:70%;">
                        <textarea class="form-control" placeholder="Распишите свою жалобу" id="report_text" name="report_text"></textarea>
                        <label for="floatingTextarea">Состав жалобы</label>
                    </div>
                    <div>
                        <div class="btn btn-danger" onclick="switch_form()">Отменить</div>
                        <div class="btn btn-success" onclick="send_report()">Отправить жалобу</div>
                    </div>
                </div>
                @endif
                <div>
                    <img src="{{ asset('imgs/projects/projects_background.jpg') }}" alt="project background" id="project_background">
                    @if($project->is_private == false)<img src="{{ asset('imgs/projects/report.png') }}" alt="report" id="project_report" onclick="switch_form()">@endif
                    <div class="d-flex flex-column">
                        <div class="project_view_controls d-flex flex-row justify-content-around row">
                            <a href="{{ route('project_view', ['id' => $project->id]) }}" style="background:green;" class="col-md-5">Просмотр</a>
                            <a href="{{ route('project_download', ['id' => $project->id]) }}" style="background:orange;" class="col-md-5">Скачивание</a>
                        </div>
                    </div>
                </div>
                <span role="project_name">
                    <?php 
                        $max = 6000;    
                        if(strlen($project->name) > $max) {
                            $res = mb_str_split($project->name, $max - 3)[0] . '...';
                            echo $res;
                        } else {
                            echo $project->name;
                        }
                    ?>
                </span>
            </div>
            <div class="project_stats row justify-content-around align-items-center">
                <div class="col-4 d-flex text-align-center justify-content-center align-items-center">
                    <img src="{{ asset('imgs/profile/views.png') }}" alt="views">
                    <span>{{ $project->views }}</span>
                </div>
                <div class="col-4 d-flex text-align-center justify-content-center align-items-center">
                    <img src="{{ asset('imgs/profile/likes_mini.png') }}" alt="likes" onclick="like()">
                    <span id="project_likes_field">{{ $project->likes }}</span>
                </div>
            </div>
        </div>
        <div class="project_description d-flex flex-column col-lg-5">
            <span role="description_title">Описание</span>
            @if(empty($project->description)) 
                <i>Описание отсутствует...</i>
            @else
                <span>{{ $project->description }}</span>
            @endif
            
            <div style="position:relative;margin-top:auto;<?= empty($project->description) ? '' : 'margin-top: 10px;' ?>">
                <span><span style="font-weight: bold; color: #444;">Опубликован:</span> {{$project->created_at}}</span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let like_url = "{{ route('project_like', ['id' => $project->id]) }}"
    let report_url = "{{ route('project_send_report') }}"
    let project_id = "{{ $project->id }}"
</script>
<script src="{{ asset('js/project_page.js') }}"></script>
@endsection