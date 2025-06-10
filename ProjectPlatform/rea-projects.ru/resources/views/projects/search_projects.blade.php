@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/projects/projects_page.css') }}">
@endsection

@section('title')
Результаты поиска
@endsection

@section('content')
<div class="search d-flex align-items-center justify-content-center flex-column">
    <div class="search_bar">
        <input type="text" id="search_input" value="<?= $searchbar_input_value ?>">
        <a href="" id="search_button"><img src="{{ asset('imgs/projects/loup.png') }}" alt="loup" style="width:80%;height:auto;"></a>
    </div>
    <div class="search_list">
        <ul id="search_list"></ul>
    </div>
</div>
<div class="projects row">
    @if($projects != [])
        @foreach($projects as $project)
            @if(($project->is_private and $show_privates == false))
                @continue
            @endif
            <div class="project col-lg-4 d-flex flex-column">
                <div id="project_background">
                    <div class="project_top">
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
    @else 
        <div class="project col-lg-4 d-flex flex-column">
            <div id="project_background">
                <div class="project_top">
                    <a href="{{ route('projects_page') }}">
                        Вернуться назад
                    </a>
                </div>
                <div class="project_down d-flex justify-content-start" style="align-self:flex-start !important; width: 100%;">
                    <div class="project_down_author d-flex flex-column justify-content-start align-items-start" style="max-width:90%;">        
                        <span role="name">Ничего не найдено</span>
                        <span role="login">Проверьте корректность запроса</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/projects_page.js') }}"></script>
<script>
    let search_data_url = "{{ route('searchbar_get_projects') }}"
    let search_url = "{{ route('searchbar_find_projects', ['name' => '']) }}"
</script>
@endsection

