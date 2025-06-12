@extends('layouts.layout')


@section('title')
    <?= $edit ? 'Редактировать товар' : 'Создать товар' ?>
@endsection


@section('content')
    @if ($errors)
        @foreach ($errors->all() as $error)
            <div class="alert alert_danger">
                {{ $error }}
            </div>
        @endforeach    
    @endif
    <form class="form" action="<?= $edit ? route('products.edit', ['category_id' => $product->category, 'product_id' => $product->id]) : '' ?>" method="POST">
        @csrf

        @if (!$edit)
            <div class="form__group">
                <label class="form__label" for="category_id">Категория</label>
                <select name="category_id" id="category_id" class="form__input">
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="form__group">
            <label class="form__label" for="name">Наименование</label>
            <input class="form__input" type="text" name="name" id="name" value="<?= $edit ? $product->name : old('name') ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="price">Цена</label>
            <input class="form__input" type="text" name="price" id="price" value="<?= $edit ? $product->price : old('price') ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="description">Описание</label>
            <textarea class="form__input form__textarea" type="text" name="description" id="description"><?= $edit ? $product->description : old('description') ?></textarea>
        </div>
        <input class="btn form__submit" type="submit" value="<?= $edit ? 'Обновить' : 'Создать' ?>">
    </form>
@endsection
