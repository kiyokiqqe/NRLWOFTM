@extends('layouts.app')

@section('title', 'Мої папки')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ваші папки</h2>
        <a href="{{ route('folders.create') }}" class="btn btn-primary">+ Нова папка</a>
    </div>

    {{-- 🔍 Пошук --}}
    <form method="GET" action="{{ route('folders.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Пошук папок..." value="{{ $search }}">
            <button type="submit" class="btn btn-outline-secondary">Пошук</button>
            @if ($search)
                <a href="{{ route('folders.index') }}" class="btn btn-outline-danger">Очистити</a>
            @endif
        </div>
    </form>

    {{-- ✅ Повідомлення про успіх --}}
    @if (session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    {{-- 📂 Таблиця з папками --}}
    @if ($folders->count())
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Назва папки</th>
                    <th style="width: 200px;">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($folders as $folder)
                    <tr>
                        <td>{{ $folder->folder_name }}</td>
                        <td>
                            <a href="{{ route('folders.show', $folder) }}" class="btn btn-sm btn-outline-primary">Відкрити</a>
                            <a href="{{ route('folders.edit', $folder) }}" class="btn btn-sm btn-outline-warning">Редагувати</a>
                            <form action="{{ route('folders.destroy', $folder) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Видалити папку?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted mt-4">Нічого не знайдено за запитом "{{ $search }}".</p>
    @endif
@endsection
