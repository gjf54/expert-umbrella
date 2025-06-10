@extends('layouts.dashboard_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/dashboard/moderation/reports/main.css') }}">
@endsection 

@section('title')
    Модерирование проектов
@endsection

@section('content')
    <div class="reports row">
        @forelse ($reports as $report)

                <div class="report col-lg-4 col-xl-3">
                    <div class="report_background">
                        <div>
                            <span role="report_title"><a href="{{ route('moderation_reports_report_page', ['id' => $report->id]) }}" style="color:#000;">{{ "Жалоба #" . $report->id }}</a></span>
                        </div>
                        <div class="d-flex flex-column">
                            <span>Проект: <a href="{{ route('project_page', ['id' => $report->project_id]) }}">{{ $report->project->name }}</a></span>
                            <span>Автор проекта: <a href="{{ route('user_profile_view', ['id' => $report->project->user->id]) }}">{{ '@' . $report->project->user->login }}</a> </span>
                        </div>
                        <div>
                            <span>Заявитель: <a href="{{ route('user_profile_view', ['id' => $report->user_id]) }}">{{ '@' . $report->user->login }}</a></span>
                        </div>
                    </div>
                </div>    
        @empty
        <div class="report col-lg-4 col-xl-3">
            <div class="report_background">
                <div>
                    <span role="report_title"><a href="{{ route('dashboard_moderation') }}" style="color:#000;">Вернуться назад</a></span>
                </div>
                <div class="d-flex flex-column">
                    <span>Пока никто не оставлял жалоб</span>
                    <span>Проверьте жалобы позже</span>
                </div>
            </div>
        </div>
        @endforelse
    </div>
@endsection