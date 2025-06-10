@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/welcome.css') }}">
@endsection

@section('title')
Principal Market - Главная
@endsection()

@section('content')
<i style="font-size:12px;margin:20px;">Сайт находится в альфа версии и продолжает разрабатываться</i>
<div class="header">
    <img src="{{ asset('storage/imgs/welcome_page/header.jpg') }}" alt="header">
    <div class="header_text">
        <span role="title">Проект Онлайн Магазина</span>
        <span role="text">Данный проект был разработан для подтверждения уровня квалификации в области разработки веб-приложений. Автор - Горобцов Юрий Викторович.</span>
        <a href="https://github.com/gjf54/MyPlatform" class="col-sm-12 col-md-2 btn btn-primary btn-lg active" aria-disabled="true" role="button">Открытый код на GitHub</a> 
    </div>
</div>

<div class="description">
    <span role="title">Основные разделы в проектировании приложения</span>
    <ul>
        <li>Работа с базами данных: проектирование архитектуры и решение задач обработки информации с реляционным подходом</li>
        <li>Создание адаптивных макетов для поддержки кроссплатформенности</li>
        <li>Организация back-end'а: взайимодействие с базой данных и обработка внутрисерверных и клиентских запросов</li>
        <li>Настройка и поддержка сервера: использование сетевых протоколов связи (FTP, HTTP), регулирование правилами адрессации http-запросов и обеспечение безопасности соединения</li>
    </ul>
</div>

<div class="figures row d-flex align-items-center justify-content-around">
    <div class="figure col-sm-12 col-md-5">
        <div>
            <img src="{{ asset('storage/imgs/welcome_page/database.jpg') }}" alt="figure">
            <span role="title">База Данных</span>
        </div>
        <span role="text">Для реализации взаимодействия с БД используется объектно-ориентированная типизация (использование моделей и модели базы данных с набором основных команд управления БД). Основной метод построения БД - миграции. Реализация всех видов реляционных связей (1 -> 1, 1 -> &#8734, &#8734 -> &#8734)</span>
    </div>
    <div class="figure col-sm-12 col-md-5">
        <div>
            <img src="{{ asset('storage/imgs/welcome_page/crossplatform.jpg') }}" alt="figure">
            <span role="title">Кроссплатформенность</span>
        </div>
        <span role="text">Использование основных подходов к реализации адаптивности: написание медиа-запросов, использование grid'ов, использование flexbox'ов и применение библиотеки Bootstrap с набором встроенных классов для модификации элементов страниц.</span>
    </div>
    <div class="figure col-sm-12 col-md-5">
        <div>
            <img src="{{ asset('storage/imgs/welcome_page/backend.png') }}" alt="figure">
            <span role="title">Back-end</span>
        </div>
        <span role="text">Оперирование наборами встроенных классов php-фреймворка Laravel и модификация конфигураций системы взаимодействий компонентов фреймворка Laravel. Примеры реализованных задач: обработка запросов с использованием параметров, регистрация сторонних файлов и последующее оперирование ими, реализация системы регистрации пользователей и дргуие...</span>
    </div>
    <div class="figure col-sm-12 col-md-5">
        <div>
            <img src="{{ asset('storage/imgs/welcome_page/server.jpg') }}" alt="figure">
            <span role="title">Конфигурация Сервера</span>
        </div>
        <span role="text">Обеспечение сайта защитным протоколом SSL для проведения безопасного соединнения. Применение протоколов SSH (сетевой протокол для настройки операционной системы удаленного сервера), FTP (протокол предачи файловых пакетов между удаленным сервером и локальной системой) и использование GIT для создания системы обновления ресурса.</span>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endsection