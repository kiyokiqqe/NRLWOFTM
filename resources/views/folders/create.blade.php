@extends('layouts.app')

@section('title', 'Створити папку')

@section('content')
    <h1>Створити нову папку</h1>

    <form action="{{ route('folders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="folder_name" class="form-label">Назва папки</label>
            <input type="text" name="folder_name" id="folder_name" class="form-control" required value="{{ old('folder_name') }}">
        </div>

        <button type="submit" class="btn btn-success">Створити</button>
        <a href="{{ route('folders.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
@endsection
