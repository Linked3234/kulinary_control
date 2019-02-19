@extends('layouts.app')

@section('title', $title.' / Редактирование')
@section('header')
<a href="{{ route('categories.index', ['type' => $type]) }}">{{ $title }} / Редактирование</a>
@endsection

@section('content')

<form method="POST" action="{{ route('categories.update', ['type' => $type, 'id' => $category->id]) }}">
    @csrf
    <div class="row">
        <div class="col-9">
            <label for="name">Название категории</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div class="col-3">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-success col-12">Сохранить изменения</button>
        </div>
    </div>
</form>

@endsection