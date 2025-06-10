<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://gist.githubusercontent.com/c-kick/2d717790aadd3aa86884ee0b07c3119f/raw/1e0320625d1988c0a269acd250ea55cfc01519c8/hnl.mobileConsole.js"></script>
    <script>
        mobileConsole.init()
    </script>
    <link rel="stylesheet" href="{{ asset('styles/layout.css') }}">
    @yield('styles')
    <title>@yield('title')</title>
</head>

<body>
    <div class="black_block"></div>
    <div class="container">
        <div class="navi row d-flex flex-row justify-content-around align-items-center">
            <a href="/" class="col-sm-12 col-md-2 btn btn-primary btn-lg active" aria-disabled="true" role="button">Главная</a>
            <a href="{{ route('catalog') }}" class="col-sm-12 col-md-2 btn btn-primary btn-lg active" aria-disabled="true" role="button">Каталог</a>
            <a href="{{ route('shopping_cart') }}" class="col-sm-12 col-md-2 btn btn-primary btn-lg active" aria-disabled="true" role="button">Корзина</a>
            <a href="{{ route('profile') }}" class="col-sm-12 col-md-2 btn btn-primary btn-lg active profile_title" aria-disabled="true" role="button"></a>
        </div>
        <div class="collapse" id="navbarToggleExternalContent">
          <div class="bg-white p-4">
            <div class="hidden row d-flex flex-row justify-content-around align-items-center">
              <a href="/" class="col-sm-12 col-md-2 btn btn-primary btn-lg active" aria-disabled="true" role="button">Главная</a>
              <a href="{{ route('catalog') }}" class="col-sm-12 col-md-2 btn btn-primary btn-lg active" aria-disabled="true" role="button">Каталог</a>
              <a href="{{ route('shopping_cart') }}" class="col-sm-12 col-md-2 btn btn-primary btn-lg active" aria-disabled="true" role="button">Корзина</a>
              <a href="{{ route('profile') }}" class="col-sm-12 col-md-2 btn btn-primary btn-lg active profile_title" aria-disabled="true" role="button"></a>
            </div>
          </div>
        </div>
        <div class="navbar navbar-white bg-white burger">
          <div class="container-fluid">
            <div class="burger_container">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
              </button>
              <span style="font-weight: bold; font-size: 24px">Меню</span>
            </div>
          </div>
        </div>
        @yield('content')
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script>
    const checkAuth = "{{ route('checkAuth') }}"
  </script>
  <script src="{{ asset('js/main_layout.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  @yield('scripts')

</body>

</html>
