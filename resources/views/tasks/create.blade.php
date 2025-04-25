@extends('layouts.app')

@section('title', 'Створити завдання')

@section('content')
    <h1>Створити нове завдання</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="task_name" class="form-label">Назва завдання</label>
            <input type="text" name="task_name" id="task_name" class="form-control"
                   required value="{{ old('task_name') }}">
        </div>

        <div class="mb-3">
            <label for="task_description" class="form-label">Опис</label>
            <textarea name="task_description" id="task_description" class="form-control" rows="4">{{ old('task_description') }}</textarea>
        </div>

        @if (isset($selectedFolder))
            <input type="hidden" name="folder_id" value="{{ $selectedFolder->id }}">
            <p><strong>Папка:</strong> {{ $selectedFolder->folder_name }}</p>
        @else
            <div class="mb-3">
                <label for="folder_id" class="form-label">Папка</label>
                <select name="folder_id" id="folder_id" class="form-select" required>
                    <option value="">Оберіть папку</option>
                    @foreach ($folders as $folder)
                        <option value="{{ $folder->id }}" {{ old('folder_id') == $folder->id ? 'selected' : '' }}>
                            {{ $folder->folder_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Очікує" {{ old('status') == 'Очікує' ? 'selected' : '' }}>Очікує</option>
                <option value="У процесі" {{ old('status') == 'У процесі' ? 'selected' : '' }}>У процесі</option>
                <option value="Завершено" {{ old('status') == 'Завершено' ? 'selected' : '' }}>Завершено</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Пріоритет</label>
            <select name="priority" id="priority" class="form-select" required>
                <option value="Низький" {{ old('priority') == 'Низький' ? 'selected' : '' }}>Низький</option>
                <option value="Середній" {{ old('priority') == 'Середній' ? 'selected' : '' }}>Середній</option>
                <option value="Високий" {{ old('priority') == 'Високий' ? 'selected' : '' }}>Високий</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Кінцевий термін</label>
            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}">
        </div>

        <button type="submit" class="btn btn-success">Створити</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
@endsection
