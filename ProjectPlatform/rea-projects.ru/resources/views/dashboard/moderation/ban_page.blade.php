@extends('layouts.dashboard_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/dashboard/moderation/ban_page.css') }}">
@endsection

@section('title')
    {{ 'Бан #' . $ban->id  }}
@endsection

@section('content')
    <span role="ban_title">{{ 'Бан #' . $ban->id  }}</span>
    <div class="ban row">
        <div class="ban_info col-lg-12 col-xl-7">
            <div class="ban_members d-flex flex-column">
                <span>Заблокированный пользователь: <span><a href="{{ route('user_profile_view', ['id' => $ban->banned_user_id]) }}">{{ '@' . $ban->user->login }}</a></span></span>
                <span>Модератор: <span><a href="{{ route('user_profile_view', ['id' => $ban->moderator_id]) }}">{{ '@' . $ban->moderator->login }}</a></span></span>
            </div>
            <div class="ban_time">
                <span>Время блокировки: <span>{{ $ban->created_at }}</span></span>
            </div>
            <div class="ban_reason d-flex flex-column">
                <span role="ban_reason_title">Причина</span>
                @if (empty($ban->reason))
                    <i>Причина не была указана...</i>
                @else
                <span role="ban_reason_text">{{ $ban->reason }}</span>
                @endif
            </div>
        </div>
        <div class="ban_control col-lg-12 col-xl-5">
            <div>
                <span role="ban_control_title">Управление блокировкой</span>
                <div style="margin-top: 20px">
                    @php($url = route('dashboard_moderation_unban', ['id' => $ban->id]))
                    <div class="btn btn-danger" onclick="unban_user('{{ $url }}', {{ $ban->id }})">Разблокировать</div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('dashboard_moderation_bans') }}" class="btn btn-outline-secondary" style="margin-left: 10px">Вернуться назад</a>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/moderation/ban_page.js') }}"></script>
@endsection