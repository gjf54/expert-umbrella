<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('styles/common/layouts/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/common/main.css') }}">
    @yield('styles')
    <title>@yield('title')</title>
</head>
<body>
    <div class="nav">
        <div class="nav__element">
            <a class="nav__link" href="/">Главная</a>
        </div>
        <div class="nav__element">
            <a class="nav__link" href="{{ route('categories.index') }}">Категории</a>
        </div>
        <div class="nav__element">
            <a class="nav__link" href="{{ route('products.index') }}">Продукты</a>
        </div>
        <div class="nav__element">
            <a class="nav__link" href="{{ route('orders.index') }}">Заказы</a>
        </div>
        <div class="nav__element">
            <a class="nav__link" href="{{ route('carts.index') }}">Корзина</a>
        </div>
    </div>

    @yield('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    @yield('scripts')
</body>
</html>
