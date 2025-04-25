@extends('layouts.app')

@section('title', 'Редагувати папку')

@section('content')
    <h1>Редагувати папку</h1>

    <form action="{{ route('folders.update', $folder->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="folder_name" class="form-label">Назва папки</label>
            <input type="text" name="folder_name" id="folder_name" class="form-control"
                   value="{{ old('folder_name', $folder->folder_name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Оновити</button>
        <a href="{{ route('folders.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
@endsection
