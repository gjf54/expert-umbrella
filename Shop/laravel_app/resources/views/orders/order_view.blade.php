@extends('layouts.main_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('styles/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/orders/order_view.css') }}">
@endsection

@section('title')
    Просмотр заказа
@endsection 

@section('content')
    <div class="order">
        <span role="order_title"><?= '#' . $order->id ?></span>
        <div class="order_container">
            @foreach($order->order_products as $el)
                @php($product = App\Models\Product::find(['id' => $el->product_id])->first())
                <div class="order_product">
                    <div class="order_product_info">
                        <a href="{{ route('catalog_product_view', ['id_category' => $product->category_id, 'id_product' => $product->id]) }}">
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
                        </a>
                    </div>
                </div>  
            @endforeach
        </div>
    </div>
@endsection