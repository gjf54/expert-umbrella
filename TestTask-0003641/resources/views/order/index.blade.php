@extends('layouts.layout')


@section('styles')
    <link rel="stylesheet" href="{{ asset("styles/common/orders/index.css") }}">
@endsection


@section('title')
    {{ sprintf('Заказы (%d)', $orders->count()) }}
@endsection


@section('content')
    <div class="orders">
        @foreach ($orders->reverse() as $order)
            <div class="orders__element">
                <a class="orders__link" href="{{ route('orders.show', ['order_id' => $order->id]) }}">
                    {{ '#' . $order->id }}
                </a>

                <div class="orders__description">
                    <span>Цена заказа: <span style="color:green;">{{ $order->cost() }}</span> RUB</span>
                    <span>Заказчик: {{ $order->customer }}</span>
                    <span>Дата создания: {{ $order->created_at }}</span>
                    <span>Статус заказа: {{ $order->status() }}</span>
                </div>        
            </div>                
        @endforeach
    </div>    
@endsection