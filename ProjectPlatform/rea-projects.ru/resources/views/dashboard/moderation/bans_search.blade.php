@extends('layouts.dashboard_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/dashboard/moderation/bans.css')}}">
@endsection

@section('title')
    Поиск блокировок
@endsection 

@section('content')
    @if($bans != [])
        @foreach($bans as $ban)
            @php($user = $ban->user)
            <div class="ban col-md-6 col-lg-4 col-xl-4 col-xxl-3 d-flex flex-column" id="{{ 'ban-' . $ban->id }}">
                <div class="ban_background d-flex flex-row justify-content-between">
                    <div class="d-flex flex-column" style="height: 100%;">
                        <span role="banned_login"><a href="{{ route('user_profile_view', ['id' => $user->id]) }}">{{ '@' . $user->login }}</a></span>
                        <div class="d-flex flex-column justify-content-end" style="position: relative; margin-top: auto;">
                            <span role="moderator_login">Выдал бан: <a href="{{ route('user_profile_view', ['id' => $ban->moderator->id]) }}">{{ '@' . $ban->moderator->login }}</a></span>
                            <span role="date">Дата выдачи: {{ $ban->created_at }}</span>
                            <a href="{{ route('dashboard_moderation_ban_page', ['id' => $ban->id]) }}" style="font-size: 10px;">Подробнее...</a>
                        </div>
                    </div>
                    <div>
                        @php($url = route('dashboard_moderation_unban', ['id' => $ban->id]))
                        <div class="ban_remove_button" onclick="unban_user('{{ $url }}', {{$ban->id}})" id="{{ 'ban-button' . $ban->id }}"></div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="ban col-md-6 col-lg-4 col-xl-4 col-xxl-3 d-flex flex-column">
            <div class="ban_background d-flex flex-row justify-content-between">
                <div class="d-flex flex-column" style="height: 100%;">
                    <span role="banned_login"><a href="{{ route('dashboard_moderation_bans') }}">Вернуться назад</a></span>
                    <div class="d-flex flex-column justify-content-end" style="position: relative; margin-top: auto;">
                        <span role="moderator_login">Ничего не найдено</span>
                        <span role="date">У такого пользователя нет блокировки</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
@endsection