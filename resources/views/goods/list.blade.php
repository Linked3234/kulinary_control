@extends('layouts.app')

@section('title', $title)
@section('header')

    {{--<div class="container">--}}
    {{--Список товаров--}}
    {{--</div>--}}

@endsection

@section('content')

    <div class="row">
        <div class="col-3">

            {{--<h4>Категории</h4>--}}
            <ul class="categories_list">
                <li @if($category_id == 'all') class="active" @endif><a href="{{ route('goods.list', ['category_id' => 'all']) }}">Все</a></li>
                @foreach($categories as $key => $value)
                    <li @if($value->id == $category_id) class="active" @endif><a href="{{ route('goods.list', ['category_id' => $value->id]) }}">{{ $value->name }}</a></li>
                @endforeach
            </ul>

        </div>
        <div class="col-6">
            <table class="table table-goods-order" border="0">
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th>ID</th>--}}
                    {{--<th>Название товара</th>--}}
                    {{--<th>Категория</th>--}}
                    {{--<th>Действия</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                <tbody>
                @foreach($goods as $key => $value)
                    <tr>
                        {{--<td class="good_id">{{ $value->id }}</td>--}}
                        <td class="good_name" style="width: 80%;">{{ $value->name }}</td>
                        {{--<td class="good_category_name">--}}
                            {{--{{ $value->category_good()->name }}--}}
                        {{--</td>--}}
                        <td style="width: 20%;">
                            <div class="create-order" style="width: 250px;">
                                <input type="hidden" name="good_id" value="{{ $value->id }}">
                                <input type="hidden" name="category_id" value="{{ $value->category_good()->id }}">
                                <input type="hidden" name="category_manufacturing" value="{{ $value->category_manufacturing()->id }}">
                                <input type="hidden" name="category_stock" value="{{ $value->category_stock()->id }}">
                                <button type="button" class="act-minus btn btn-primary" style="display: inline-block;">-</button>
                                <input type="number" name="count" min="0" max="100000" value="0" style="display: inline-block; width: 70px;" class="form-control">
                                <button type="button" class="act-plus btn btn-primary" style="display: inline-block;">+</button>
                                <button type="button" class="btn btn-primary basket_add"><i class="fas fa-shopping-basket"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-3">
            {{--<h4>Корзина</h4>--}}
            <div class="col-12">
                <button type="button" class="btn btn-default clear-basket">Очистить корзину</button>
            </div>
            <div id="basket_items" class="col-12">
                {!! $basket_list !!}
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-default create_order_btn" data-toggle="modal" data-target="#create_order">Отправить заказ</button>
            </div>
        </div>
    </div>

    {{-- Добавление товара в корзину --}}
    {{--<div class="modal fade" id="basket" tabindex="-1" role="dialog" aria-labelledby="basket" aria-hidden="true">--}}
        {{--<div class="modal-dialog" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h5 class="modal-title" id="basket_title"></h5>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                    {{--</button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-12">--}}
                            {{--<label for="count">Количество</label>--}}
                            {{--<input type="text" name="count" class="form-control">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>--}}
                    {{--<input type="hidden" name="good_id" value="">--}}
                    {{--<input type="hidden" name="category_id" value="">--}}
                    {{--<input type="hidden" name="category_manufacturing" value="">--}}
                    {{--<input type="hidden" name="category_stock" value="">--}}
                    {{--<button type="button" class="btn btn-primary basket_add">Добавить в корзину</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


    {{-- Оформление заказа --}}
    <div class="modal fade" id="create_order" tabindex="-1" role="dialog" aria-labelledby="create_order" aria-hidden="true">
        <form method="POST" action="{{ route('order.create') }}">
            @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="create_order_title">Оформление заказа</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="comment">Комментарий к заказу</label>
                                    <textarea name="comment" id="comment" placeholder="Необязательно" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-success">Оформить</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>

@endsection