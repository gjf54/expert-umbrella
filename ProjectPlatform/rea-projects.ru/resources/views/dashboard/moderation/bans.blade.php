@extends('layouts.dashboard_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/dashboard/moderation/bans.css') }}">
@endsection

@section('title')
Блокировки пользователей
@endsection

@section('content')
<div class="search d-flex flex-column">
    <div class="d-flex flex-column justify-content-center align-items-center" style="width: 40%; margin-left:auto; height: auto;">
        <div class="search_bar">
            <input type="text" id="search_input" autocomplete="off" placeholder="Логин заблокированного пользователя">
            <a href="" id="search_button"><img src="{{ asset('imgs/projects/loup.png') }}" alt="loup" style="width:60%;height:auto;"></a>
        </div>
        <div class="search_list">
            <ul id="search_list"></ul>
        </div>
    </div>
</div>
<div class="bans row">
    <div class="ban ban_add col-md-6 col-lg-4 col-xl-4 col-xxl-3">
        <div class="ban_background d-flex justify-content-center align-items-center">
            <a href="{{ route('dashboard_moderation_ban_form') }}">Выдать бан</a>
        </div>
    </div>
    @php
        $count = 0;
        $max_count = 33;
    @endphp

    @foreach($bans->reverse() as $ban)
        @php($count += 1)
        @if ($count > $max_count)
            @break
        @endif
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
</div>
@endsection

@section('scripts')
    <script> 
        search_data_url = "{{ route('dashboard_moderation_bans_find') }}"
        search_url = "{{ route('dashboard_moderation_bans_search', ['login' => '']) }}"
    </script>
    <script src="{{ asset('js/dashboard/moderation/bans.js') }}"></script>
@endsection
