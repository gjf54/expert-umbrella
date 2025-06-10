@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/projects/projects_page.css') }}">
<style>
    #red_circle, #green_circle {
        border-radius: 50%;
        width: 15px;
        height: 15px;
        opacity: 0.6;
    }

    #red_circle {
        background: #F00;
    }

    #green_circle {
        background: #0F0;
    }
</style>
@endsection

@section('title')
Проекты
@endsection

@section('content')
<div class="projects row">
    @foreach($projects->reverse() as $project)
        @if($project->is_private and $show_privates == false)
            @continue
        @endif
        <div class="project col-lg-4 d-flex flex-column">
            <div id="project_background">
                <div class="project_top d-flex flex-row justify-content-between">
                    <a href="{{ route('project_page', ['id' => $project->id]) }}">
                        <?php      
                            $max = 25;    
                            if(strlen($project->name) > $max) {
                                $res = mb_str_split($project->name, $max - 3)[0] . '...';
                                echo $res;
                            } else {
                                echo $project->name;
                            }
                        ?>
                    </a>
                    <div class="d-flex flex-row align-items-center justify-content-between" style="min-width:60px;">
                        @if($project->is_private)
                            <div id="red_circle"></div>
                        @else
                            <div id="green_circle"></div>
                        @endif
                        <a href="{{ route('project_settings_page', ['id' => $project->id]) }}" class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('imgs/profile/settings2.png') }}" alt="settings" style="width:30px;height:30px;">
                        </a>
                    </div>
                </div>
                <div class="project_down d-flex justify-content-between align-items-end">
                    <div class="project_down_author d-flex flex-column">
                        @if($project->user->name == null)
                            <span role="name">{{ '@' . $project->user->login }}</span>
                        @else
                            <span role="name">{{ $project->user->name }} {{ $project->user->last_name }}</span>
                            <span role="login">{{ '@' . $project->user->login }}</span>
                        @endif
                    </div>
                    <div class="project_down_stats d-flex flex-row algin-items-end">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ asset('imgs/profile/views.png') }}" alt="views">
                            <span>{{ $project->views }}</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ asset('imgs/profile/likes.png') }}" alt="likes">
                            <span>{{ $project->likes }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection