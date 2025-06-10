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
                <div class="d-flex flex-row align-items-start">
                    <div class="d-flex flex-column">
                        @if($user->name != null)
                            <span role="name">{{ $user->name . ' ' . $user->last_name }}</span>
                            <span role="login">{{ '@' . $user->login }}</span>
                        @else
                            <span role="name">{{ '@' . $user->login }}</span>
                        @endif
                    </div>
                    <img src="{{ asset('imgs/profile/edit.png') }}" alt="edit" id="user_info_edit_icon" onclick="show_edit_list()">
                </div>
                <div style="position:relative;">
                    <ul id="user_edit_list">
                        <li><a href="{{ route('profile_name_edit_form') }}">Изменить имя</a></li>
                        <li><a href="{{ route('profile_avatar_edit_form') }}">Изменить аватар</a></li>
                        <li><a href="{{ route('profile_password_edit_form') }}">Изменить пароль</a></li>
                        <li><a href="{{ route('profile_add_edit_form') }}">Рассказать о себе</a></li>
                    </ul>
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

                <!-- Register new role here -->

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

    <div class="master">
        <div class="master_data_limit d-flex flex-column justify-content-center">
            <span>Ваш лимит: <strong>{{ $user->data_limit . 'МБ' }}</strong></span>
            <div class="progress_bar d-flex flex-row justify-content-center align-items-center">
                <div style="width:{{ ($user->get_data_size() * 100) / $user->data_limit . '%' }};"></div>
                <span>{{ $user->get_data_size() . 'МБ' }}</span>
            </div>
        </div>

        @if($user->can('moderate'))
            <div>
                <a href="/dashboard" id="master_dashboard">Панель управления</a>
            </div>
        @endif
        
        <div>
            <a href="{{ route('logout') }}" id="master_logout">Выйти из аккаунта</a>
        </div>
    </div>

    <div class="projects">
        <div class="projects_add d-flex flex-column align-items-center justify-content-center">
            <a href="{{ route('project_upload_form') }}" class="d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('/imgs/profile/plus.png') }}" alt="plus_icon" id="project_add_icon">
                <span>Добавить проект</span>
            </a>
        </div>
        <?php 
            $projects_count = 0;
            $projects_limit = 4
        ?>
        @foreach($user->projects->reverse() as $project)
            @if($projects_count == $projects_limit)
                <div class="project projects_more">
                    <a href="{{ route('profile_projects_view') }}">Посмотреть все</a>
                </div>
                @break
            @endif
            <?php $projects_count += 1 ?>
            <div class="project">
                <img src="{{ asset('imgs/profile/projects_background.jpg') }}" alt="projects background">
                <div class="project_container">
                    <div class="d-flex flex-row justify-content-between align-items-center align-self-start project_links">
                        <a href="{{ route('project_page', ['id' => $project->id])  }}">
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
                        <a href="{{ route('project_settings_page', ['id' => $project->id]) }}"><img src="{{ asset('imgs/profile/settings.png') }}" alt=""></a>
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

@section('scripts') 
<script src="{{ asset('js/profile.js') }}"></script>
@endsection