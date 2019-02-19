@extends('layouts.app')

@section('title')
    Заказ № {{ $order->order_id }}
@endsection
@section('header')

    Заказ № {{ $order->order_id }}
@endsection

@section('content')

    <p>Дата заказа: {{ date('d.m.Y H:i', $order->date) }}</p>
    <p>Комментарий: {{ $order->comment }}</p>
    {!!  $order->goods_mail !!}

@endsection