@extends('layouts.app')

@section('title', 'Список заказов')
@section('header', 'Список заказов')

@section('content')

    <a href="{{ route('goods.list', ['category_id' => 'all']) }}" class="btn btn-link">Вернуться к оформлению заказа</a>
    <table class="table" border="0">
        <thead>
        <tr>
            <th>№ заказа</th>
            <th>Дата оформления</th>
            <th>Комментарий</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $key => $value)
            <tr>
                <td>{{ $value->order_id }}</td>
                <td>{{ date('d.m.Y H:i', $value->date) }}</td>
                {{--<td>{!! $value->goods  !!}</td>--}}
                <td>{{ $value->comment }}</td>
                <td>
                    <a href="{{ route('order.watch', $value->id) }}" target="_blank">Открыть</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection