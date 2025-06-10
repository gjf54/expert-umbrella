<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('imgs/layouts/main_layout/icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('/styles/layouts/main_layout.css') }}">
    <style>
        body {
            background-image: url("{{ asset('imgs/layouts/main_layout/background.png') }}");
        }
        @font-face {
            font-family: DeleddaClosedBlack;
            src: url("{{ asset('fonts/Deledda/Deledda\ Closed\ Black.ttf') }}");
        }
    </style>
    @yield('styles')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    @yield('scripts')
    <title>@yield('title')</title>
</head>

<body>
    <div class="container">
        <div class="nav row d-flex justify-content-between align-items-center flex-row">
            <a href="/" class="col-sm-12 col-md-4 flag"><img src="{{ asset('imgs/layouts/main_layout/logo.svg') }}" alt="logo"></a>
            <div id="nav_links" class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-around align-items-center">
                <a href="{{ route('projects_page') }}">Проекты</a>
                <a href="/info">Инфо</a>
                @if(auth()->user())
                    <a href="/profile">Профиль</a>
                @else
                    <a href="{{ route('login_page') }}">Войти</a>
                @endif
            </div>
            <div id="nav_background"></div>
        </div>
        @yield('content')
        <span style="opacity:0;">1</span>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    
    @section('scripts')
</body>

</html>