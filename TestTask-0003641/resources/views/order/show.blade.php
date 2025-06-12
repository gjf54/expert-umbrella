@extends('layouts.layout')


@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/common/orders/show.css') }}">
@endsection


@section('title')
    {{ sprintf('Заказ #%d', $order->id) }}
@endsection


@section('content')
    <div class="order">
        <span class="order__field order__link" onclick="copy_order_link()">#{{ $order->id }}</span>
        <span class="order__field">Заказчик: {{ $order->customer }}</span>
        <span class="order__field">Стоимость: <span style="color:green;">{{ $order->cost() }}</span> RUB</span>
        <span class="order__field">Статус: <span id="status">{{ $order->status() }}</span></span>

        <div class="order__description">
            <span class="order__field">Комментарий</span>
            <span class="order__field">{{ $order->comment }}</span>
        </div>

        <div class="order__description">
            <span class="order__field">Состав заказа</span>
            <div class="order__description">
                @foreach ($order->products as $note)
                    @php
                        $product = $note->product;
                    @endphp
                    <span class="order__field">{{ $product->name }} * {{ $note->amount }} = <span style="color:green;">{{ $note->cost() }}</span> RUB</span>
                @endforeach
            </div>
        </div>

        <span class="order__field">Дата создания: {{ $order->created_at }}</span>
        
        @php
            $status_manager = new App\Modules\OrderStatusManager($order);
        @endphp

        @if (! $status_manager->is_ended())
            <div class="order__field" id="end_order_section">
                <div class="btn" onclick="end_order('{{ route('orders.finish') }}')">Завершить</div>
            </div>
        @endif
    </div>
@endsection


@section('scripts')
    <script>
        function copy_order_link() {  
            navigator.clipboard.writeText("{{ route('orders.show', ['order_id' => $order->id]) }}")
            alert("Ссылка скопирована!")
        }

        let order = "{{ $order->id }}"
    </script>
    <script src="{{ asset('js/order.js') }}"></script>
@endsection