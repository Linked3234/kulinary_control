@extends('layouts.app')

@section('title', 'Товары / Новый')
@section('header')
    <a href="{{ route('goods.index') }}">Товары</a> / Новый
@endsection

@section('content')

    <form method="POST" action="{{ route('goods.store') }}">
        @csrf
        <div class="row">
            <div class="col-9">
                <label for="name">Название товара</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-3">
                <label for="measure">Единица измерения</label>
                <select name="measure" id="measure" class="form-control" required>
                    <option value="л.">Литры</option>
                    <option value="кг.">Килограммы</option>
                    <option value="шт.">Штуки</option>
                    <option value="м.">Метры</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="category_good">Категория (товарная)</label>
                <select name="category_good" id="category_good" class="form-control" required>
                    @foreach($categories_good as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="category_stock">Категория (складская)</label>
                <select name="category_stock" id="category_stock" class="form-control" required>
                    @foreach($categories_stock as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="category_manufacturing">Категория (производственная)</label>
                <select name="category_manufacturing" id="category_manufacturing" class="form-control" required>
                    @foreach($categories_manufacturing as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-success col-12">Добавить</button>
            </div>
        </div>
    </form>

@endsection