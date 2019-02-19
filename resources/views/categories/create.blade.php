@extends('layouts.app')

@section('title', $title.' / Новая')
@section('header')
    <a href="{{ route('categories.index', ['type' => $type]) }}">{{ $title }}</a> / Новая
@endsection

@section('content')

    <form method="POST" action="{{ route('categories.store', ['type' => $type]) }}">
        @csrf
        <div class="row">
            <div class="col-9">
                <label for="name">Название категории</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-success col-12">Добавить</button>
            </div>
        </div>
    </form>

@endsection