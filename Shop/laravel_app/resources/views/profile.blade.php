@extends('layouts.main_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('styles/profile.css') }}">
@endsection

@section('title')
Profile
@endsection()

@section('content')

<div class="header">
    <div class="grey"></div>
        <div class="header_content">
            <div class="main">
                <img src="{{ asset('storage/imgs/users_avatars/'.$user->image) }}" alt="avatar">
                <div class="text">        
                    <span role="nameSurname">{{ $user->name }} {{ $user->surname }}</span>
                    <span role="login"> <?php echo '@'.$user->login ?></span>
                </div>
            </div>
            <div class="buttons">
                @if($user->can('write_posts'))
                    <div class="dropdown first">
                        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Редактировать
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('edit_data') }}">Инициалы</a></li>
                            <li><a class="dropdown-item" href="{{ route('edit_avatar') }}">Аватар</a></li>
                            <li><a class="dropdown-item" href="{{ route('edit_password') }}">Пароль</a></li>
                            <li><a class="dropdown-item" href="{{ route('edit_email') }}">Электронная почта</a></li>
                        </ul>
                    </div>
                    <div class="second">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Панель</a>
                    </div>
                @else 
                    <div class="dropdown second">
                        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Редактировать
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('edit_data') }}">Инициалы</a></li>
                            <li><a class="dropdown-item" href="{{ route('edit_avatar') }}">Аватар</a></li>
                            <li><a class="dropdown-item" href="{{ route('edit_password') }}">Пароль</a></li>
                            <li><a class="dropdown-item" href="{{ route('edit_email') }}">Электронная почта</a></li>
                        </ul>
                    </div>
                @endif
                <div class="third">
                    <a href="{{ route('logout') }}" role="logout" class="btn btn-danger">Выйти</a>
                </div>
            </div>
        </div>
</div>  

<div class="orders">
    <span role="title" class="col-sm-12">Ваши заказы</span>
    <div class="row d-flex justify-content-around">
        @php($order_count = 0)
        @if($orders->first())
            @foreach($orders->reverse() as $order)
                @php($order_count += 1)
                @if($order_count > 4)
                    <div id="view_all_orders">
                        <a href="{{ route('view_all_orders') }}">Посмотреть все >>></a>
                    </div>
                    @break
                @endif
                <div class="order col-md-4 col-sm-12">
                    <span role="order_title"><a href="{{ route('view_order', ['id' => $order->id]) }}"><?= '#' . $order->id ?></a></span>
                    <div class="order_container">
                        @php($products_count = 0)
                        @foreach($order->order_products as $el)
                            @php($products_count += 1)
                            @if($products_count > 2)
                                <div class="order_products_view_more order_product">
                                    <a href="{{ route('view_order', ['id' => $order->id]) }}">
                                        <span>Подробнее</span>
                                    </a>
                                </div>
                                @break
                            @endif

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
            @endforeach
        @else
            <script>
                window.onload = function () {  
                    let orders = $('.orders')
                    orders.addClass('void_orders');
                }
            </script>
            <div class="empty_orders">
                <img src="{{ asset('storage/imgs/ui/empty.png') }}" alt="">
                <span>Здесь пока ничего нет</span>
            </div>
        @endif
    </div>
</div>
<span style="opacity:0;">1</span>
@endsection()
