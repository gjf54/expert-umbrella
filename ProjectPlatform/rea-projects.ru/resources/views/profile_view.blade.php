@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/user/profile.css') }}">
@endsection

@section('title')
Профиль
@endsection

@section('content')
<div class="user d-flex flex-column">
    <div class="d-flex flex-row justify-content-between">
        <div class="user_info d-flex flex-row">
            @if($user->avatar == 'default.png')
                <img src="{{ asset('imgs/avatar/default.png') }}" alt="">
            @else
                <img src="{{ asset('storage/imgs/avatars/' . $user->avatar) }}" alt="user avatar">
            @endif
            <div class="d-flex flex-column">
                @if($user->name != null)
                    <span role="name">{{ $user->name . ' ' . $user->last_name }}</span>
                    <span role="login">{{ '@' . $user->login }}</span>
                @else
                    <span role="name">{{ '@' . $user->login }}</span>
                @endif
            </div>
        </div>
        <div class="user_stats d-flex flex-row justify-content-around">
            <div class="d-flex flex-column justify-content-start align-items-center">
                <img src="{{ asset('imgs/profile/views.png') }}" alt="views">
                <span role="user_stat_counter">{{ $user->views() }}</span>
                <span role="user_stat_type">Просмотры</span>
            </div>
            <div class="d-flex flex-column justify-content-start align-items-center">
                <img src="{{ asset('imgs/profile/projects.png') }}" alt="projects">
                <span role="user_stat_counter">{{ count($user->projects) }}</span>
                <span role="user_stat_type">Проекты</span>
            </div>
            <div class="d-flex flex-column justify-content-start align-items-center">
                <img src="{{ asset('imgs/profile/likes.png') }}" alt="likes">
                <span role="user_stat_counter">{{ $user->likes() }}</span>
                <span role="user_stat_type">Лайки</span>
            </div>
        </div>
    </div>
    <div class="description">
        <div class="d-flex flex-row justify-content-start" style="margin-bottom: 10px;">
            <span role="description_title">О себе</span>

            @if($user->hasRole('super_admin'))
                <span role="user_role" id="role_super_admin">Super Admin</span>
            @endif

            @if($user->hasRole('admin'))
                <span role="user_role" id="role_admin">Admin</span>
            @endif
        </div>
        @if($user->description == null)
            <i>Тут пока ничего нет...</i>
        @else
            <i role="description_text">{{ $user->description }}</i>
        @endif
    </div>
</div>

<div class="projects" style="margin-top: 40px;">

    <?php 
        $projects_count = 0;
        $projects_limit = 5;
        
        if(Auth::user()) {
            $local_user = App\Models\User::where(['id' => Auth::user()->id])->first();
        }
    ?>
    @foreach($user->projects->reverse() as $project)
        @if (Auth::user())
            @if($project->is_private and $local_user->can('moderate') == false)
                @continue
            @endif    
        @endif
        
        @if($projects_count == $projects_limit)
            <div class="project projects_more">
                <a href="{{ route('user_projects_view', ['id' => $user->id]) }}">Посмотреть все</a>
            </div>
            @break
        @endif
        <?php $projects_count += 1 ?>
        
        <div class="project">
            <img src="{{ asset('imgs/profile/projects_background.jpg') }}" alt="projects background">
            <div class="project_container">
                <div class="d-flex flex-row justify-content-between align-items-center align-self-start project_links">
                    <a href="{{ route('project_page', ['id' => $project->id]) }}">
                        <span role="project_name">
                            <?php
                                $max = 25;    
                                if(strlen($project->name) > $max) {
                                    $res = mb_str_split($project->name, $max - 3)[0] . '...';
                                    echo $res;
                                } else {
                                    echo $project->name;
                                }
                            ?>
                        </span>
                    </a>
                </div>
                <div class="d-flex flex-row justify-content-between align-self-end align-items-end">
                    <div class="d-flex flex-row mini_icons">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ asset('imgs/profile/views.png') }}" alt="views">
                            <span role="stat">{{ $project->views }}</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ asset('imgs/profile/likes_mini.png') }}" alt="">
                            <span role="stat">{{ $project->likes }}</span>
                        </div>
                    </div>
                    <span role="mode" style="font-weight:bold;color:<?= $project->is_private ? 'red' : 'green' ?>;"><?= $project->is_private ? 'Приватный' : 'Публичный' ?></span>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

