@extends('layouts.app')

@section('title', 'Редагувати завдання')

@section('content')
    <h1>Редагувати завдання</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="task_name" class="form-label">Назва завдання</label>
            <input type="text" name="task_name" id="task_name" class="form-control"
                   value="{{ old('task_name', $task->task_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="task_description" class="form-label">Опис</label>
            <textarea name="task_description" id="task_description" class="form-control"
                      rows="4">{{ old('task_description', $task->task_description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="folder_id" class="form-label">Папка</label>
            <select name="folder_id" id="folder_id" class="form-select" required>
                @foreach ($folders as $folder)
                    <option value="{{ $folder->id }}" {{ old('folder_id', $task->folder_id) == $folder->id ? 'selected' : '' }}>
                        {{ $folder->folder_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Очікує" {{ old('status', $task->status) == 'Очікує' ? 'selected' : '' }}>Очікує</option>
                <option value="У процесі" {{ old('status', $task->status) == 'У процесі' ? 'selected' : '' }}>У процесі</option>
                <option value="Завершено" {{ old('status', $task->status) == 'Завершено' ? 'selected' : '' }}>Завершено</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Пріоритет</label>
            <select name="priority" id="priority" class="form-select" required>
                <option value="Низький" {{ old('priority', $task->priority) == 'Низький' ? 'selected' : '' }}>Низький</option>
                <option value="Середній" {{ old('priority', $task->priority) == 'Середній' ? 'selected' : '' }}>Середній</option>
                <option value="Високий" {{ old('priority', $task->priority) == 'Високий' ? 'selected' : '' }}>Високий</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Кінцевий термін</label>
            <input type="date" name="deadline" id="deadline" class="form-control"
                   value="{{ old('deadline', $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : '') }}">
        </div>

        <button type="submit" class="btn btn-success">Оновити</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Скасувати</a>
    </form>
@endsection
