<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('imgs/layouts/main_layout/icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('/styles/layouts/dashboard_layout.css') }}">
    <style> 
        body {
            background-image: url("{{ asset('imgs/layouts/main_layout/background.png') }}");
        }
    </style>
    @yield('styles')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    @yield('scripts')
    <title>@yield('title')</title>
</head>

<body>
    <div class="d-flex align-items-center" style="padding: 10px; margin: 5px; position:absolute; background:#EEE;border-radius:10px;opacity:0.4;">
        <a href="/profile" style="text-decoration:none;color:#000;font-weight:bold;">К профилю</a>
    </div>
    <div class="container">
        

        <nav class="row d-flex">
            <div class="col-md-6 nav_logo">
                <a href="/dashboard"><img src="{{ asset('imgs/dashboard/rea-logo.svg') }}" alt="REA logo" /></a>
            </div>
            <div class="col-md-2 nav_el">
                <a href="{{ route('dashboard_users') }}">Права пользователей</a>
            </div>
            <div class="col-md-2 nav_el">
                <a href="{{ route('dashboard_moderation') }}">Модерация</a>
            </div>
            <div class="col-md-2 nav_el">
                <a href="{{ route('dashboard_tokens') }}">Управление токенами</a>
            </div>
        </nav>
        
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    
    @yield('scripts')
</body>

</html>