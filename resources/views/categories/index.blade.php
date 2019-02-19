@extends('layouts.app')

@section('title', $title)
@section('header', $title)

@section('content')

    <a href="{{ route('categories.create', ['type' => $type]) }}" class="btn btn-info"><i class="fas fa-plus-square"></i></a>
    <table class="table" border="0">
        <thead>
        <tr>
            {{--<th>ID</th>--}}
            <th>Название</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $key => $value)
            <tr>
                {{--<td>{{ $value->id }}</td>--}}
                <td>{{ $value->name }}</td>
                <td>

                    <a href="{{ route('categories.edit', ['type' => $type, 'id' => $value->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('categories.destroy', ['type' => $type, 'id' => $value->id]) }}" style="display: inline-block">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="if(confirm('Подтвердите удаление категории')){return true;}else{return false;}"><i class="fas fa-trash-alt"></i></button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection