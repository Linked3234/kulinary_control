@extends('layouts.app')

@section('title', 'Список заказов')
@section('header', 'Список заказов')

@section('content')

    <table class="table" border="0">
        <thead>
        <tr>
            <th>Пользователь</th>
            <th>№ заказа</th>
            <th>Дата оформления</th>
            <th>Товары</th>
            <th>Комментарий</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $key => $value)
            <tr>
                <td>{{ $value->user()->name }}</td>
                <td>{{ $value->order_id }}</td>
                <td>{{ date('d.m.Y H:i', $value->date) }}</td>
                <td>{!! $value->goods  !!}</td>
                <td>{{ $value->comment }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection