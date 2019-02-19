@extends('layouts.app')

@section('title', 'Список товаров')
@section('header', 'Список товаров')

@section('content')

    {{--<a href="{{ route('goods.create') }}" class="btn btn-info"><i class="fas fa-plus-square"></i></a>--}}
    <div class="row">
        <div class="col-2">

            <a href="{{ route('goods.create') }}">Добавить</a>

        </div>
        <div class="col-10">

            <input type="text" name="search_goods_field" class="form-control" placeholder="Начните вводить название товара">
            @csrf

        </div>
    </div>
    <table class="table table-goods" border="0">
        <thead>
        <tr>
            <th>Название</th>
            <th>Категория товарная</th>
            <th>Категория производственная</th>
            <th>Категория складская</th>
            <th>Отображение</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($goods as $key => $value)
            <tr>
                <td>{{ $value->name }}</td>
                <td>{{ $value->category_good()->name }}</td>
                <td>{{ $value->category_manufacturing()->name }}</td>
                <td>{{ $value->category_stock()->name }}</td>
                <td>
                    @if($value->hidden == '1')

                        <span style="color: red;">Нет</span>

                    @elseif($value->hidden == '0')

                    <span style="color: green;">Да</span>

                    @endif
                </td>
                <td>

                    <a href="{{ route('goods.edit', ['id' => $value->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('goods.destroy', ['id' => $value->id]) }}" style="display: inline-block">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление товара')){return true;}else{return false;}"><i class="fas fa-trash-alt"></i></button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection