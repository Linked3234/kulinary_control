@extends('layouts.app')

@section('title', 'Товары / Новый')
@section('header')
    <a href="{{ route('goods.index') }}">Товары</a> / Новый
@endsection

@section('content')

    <form method="POST" action="{{ route('goods.update', ['id' => $good->id]) }}">
        @csrf
        <div class="row">
            <div class="col-9">
                <label for="name">Название товара</label>
                <input type="text" name="name" class="form-control" value="{{ $good->name }}" required>
            </div>
            <div class="col-3">
                <label for="measure">Единица измерения</label>
                <select name="measure" id="measure" class="form-control" required>

                    @if($good->measure == 'л.')
                        <option value="л." selected>Литры</option>
                    @else
                        <option value="л.">Литры</option>
                    @endif
                    @if($good->measure == 'кг.')
                            <option value="кг." selected>Килограммы</option>
                    @else
                            <option value="кг.">Килограммы</option>
                    @endif
                    @if($good->measure == 'шт.')
                            <option value="шт." selected>Штуки</option>
                    @else
                            <option value="шт.">Штуки</option>
                    @endif
                    @if($good->measure == 'м.')
                            <option value="м." selected>Метры</option>
                    @else
                            <option value="м.">Метры</option>
                    @endif

                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label for="category_good">Категория (товарная)</label>
                <select name="category_good" id="category_good" class="form-control" required>
                    @foreach($categories_good as $key => $value)
                        @if($value->id == $good->category_good)
                            <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                        @else
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="category_stock">Категория (складская)</label>
                <select name="category_stock" id="category_stock" class="form-control" required>
                    @foreach($categories_stock as $key => $value)
                        @if($value->id == $good->category_stock)
                            <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                        @else
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endif

                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <label for="category_manufacturing">Категория (производственная)</label>
                <select name="category_manufacturing" id="category_manufacturing" class="form-control" required>
                    @foreach($categories_manufacturing as $key => $value)
                        @if($value->id == $good->category_manufacturing)
                            <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                        @else
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <label for="hidden">Отображение</label>
                <select name="hidden" id="hidden" class="form-control" required>
                    @if($good->hidden == 'false')

                        <option value="0" selected>Показывать</option>
                        <option value="1">Скрыть</option>

                    @else

                        <option value="0">Показывать</option>
                        <option value="1" selected>Скрыть</option>

                    @endif
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-success col-12">Сохранить изменения</button>
            </div>
        </div>
    </form>

@endsection