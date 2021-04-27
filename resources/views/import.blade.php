@extends('layouts.app')

@section('content')

    <a href="{{route('exportIngredients')}}" class="text-indigo-400 hover:text-indigo-600">Export ingrediente</a>
    <br>
    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control">
        <br>
        <button class="btn btn-success">Import ingrediente</button>
    </form>

@endsection



