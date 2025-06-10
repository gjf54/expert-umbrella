@extends('layouts.main_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/orders/orders_view.css') }}">
@endsection

@section('title')
Ваши заказы
@endsection

@section('content')
    @if($orders->first())
        <div class="orders row d-flex justify-content-center align-items-center">
            @foreach($orders->reverse() as $order)
                <a href="{{ route('view_order', ['id' => $order->id]) }}" class="order_link"> 
                    <div class="order col-sm-8">
                        <div class="order_container">
                            <span role="order_title"><?= '#' . $order->id ?></span>
                            @foreach($order->order_products as $el) 
                                @php($product = App\Models\Product::find(['id' => $el->product_id])->first())
                                <div class="order_product">
                                    <div class="order_product_info d-flex flex-column">
                                        <img src="{{ asset(Storage::url($product->image)) }}" alt="Product img">
                                        <div>
                                            <?php 
                                                $curr_name = $product->name;
                                                $max_size = 22;
                                                if (strlen($curr_name) > $max_size) {
                                                    $curr_name = str_split($curr_name, $max_size - 3);
                                                    echo '<span role="order_product_name">' . $curr_name[0] . '...' .'</span>';
                                                } else {
                                                    echo '<span role="order_product_name">' . $product->name . '</span>';
                                                }
                                            ?>
                                            <span role="order_product_amount"]>{{ $product->price }} x {{ $el->amount }} = <?= $product->price * $el->amount ?></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty_orders">
            <img src="{{ asset('storage/imgs/ui/empty.png') }}" alt="">
            <span>Здесь пока ничего нет</span>
        </div>
    @endif
@endsection
