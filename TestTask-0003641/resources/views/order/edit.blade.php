@extends('layouts.layout')


@section('styles')
    
@endsection


@section('title')
    Создание заказа
@endsection


@section('content')
    @if ($errors)
        @foreach ($errors->all() as $error)
            <div class="alert alert_danger">
                {{ $error }}
            </div>
        @endforeach    
    @endif

    <form action="{{ route('orders.create') }}" method="POST" class="form">
        @csrf

        <div class="form__group">
            <label class="form__label" for="customer">ФИО заказчика</label>
            <input class="form__input" type="text" name="customer" id="customer">
        </div>
        <div class="form__group">
            <label class="form__label" for="comment">Комментарий</label>
            <textarea class="form__input form__textarea" type="text" name="comment" id="comment"></textarea>
        </div>
        <input class="btn form__submit" type="submit">
    </form>
@endsection