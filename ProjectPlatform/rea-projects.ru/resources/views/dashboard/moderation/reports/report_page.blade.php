@extends('layouts.dashboard_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/dashboard/moderation/reports/report_page.css') }}">
@endsection 

@section('title')
    {{ 'Жалоба #' . $report->id }}
@endsection 

@section('content')
    <div class="alert alert-success" id="success_message" style="display: none;"></div>
    <div class="alert alert-danger" id="fail_message" style="display: none;"></div>
    <div class="report row">
        <div class="report_info col-lg-12 col-xl-6 d-flex flex-column">
            <div>
                <span role="report_title">{{ $report->title }}</span>
            </div>
            <div class="d-flex flex-column">
                <span>Проект: <a href="{{ route('project_page', ['id' => $report->project_id]) }}">{{ $report->project->name }}</a></span>
                <span>Автор проекта: <a href="{{ route('user_profile_view', ['id' => $report->project->user->id]) }}">{{ '@' . $report->project->user->login }}</a> </span>
            </div>
            <div class="d-flex flex-column">
                <span>Состав жалобы</span>
                <span>{{ $report->description }}</span>
            </div>
            <div>
                <span>Заявитель: <a href="{{ route('user_profile_view', ['id' => $report->user_id]) }}">{{ '@' . $report->user->login }}</a></span>
            </div>
        </div>
        <div class="report_control col-lg-12 col-xl-6 d-flex flex-column">
            <span>Управление жалобой</span>
            <div class="btn btn-success" id="remove_report" name="{{ route('process_remove_report') }}" onclick="remove_report('{{ $report->id }}')">Закрыть жалобу</div>
            <div class="btn btn-warning" id="remove_project" name="{{ route('process_remove_project') }}" onclick="remove_project('{{ $report->project->id }}')">Удалить проект и закрыть жалобу</div>
            
            @if($report->project->user->ban == null and $report->project->user->can('moderate') == false)
                <div id="ban_control">
                    <div class="btn btn-danger" id="ban_user" name="{{ route('data_ban_user') }}" onclick="$('#ban_form').css('display', 'flex')">Забанить пользователя</div>
                    <div class="flex-column" id="ban_form" style="position: relative; display: none;">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" placeholder="Пароль" name="password">
                            <label for="floatingPassword">Пароль</label>
                        </div>
                        <div>
                            <div class="btn btn-danger" onclick="$('#ban_form').css('display', 'none')">Отменить</div>
                            <div class="btn btn-success" onclick="ban_user( '{{$report->id}}', '{{$report->project->user->login}}', '{{$report->description}}')">Заблокировать</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        reports_url = "{{ route('moderation_reports') }}"
    </script> 
    <script src="{{ asset('js/dashboard/moderation/report_page.js')}}"></script>
@endsection