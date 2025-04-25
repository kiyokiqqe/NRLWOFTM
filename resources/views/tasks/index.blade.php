@extends('layouts.app')

@section('title', 'Список завдань')

@section('content')
    <div class="container">
        <h1 class="mb-3">Мої завдання</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Кнопка створення завдання --}}
        <div class="mb-4">
            <a href="{{ route('tasks.create') }}" class="btn btn-success">Створити завдання</a>
        </div>

        {{-- Форма фільтрації --}}
        <form method="GET" action="{{ route('tasks.index') }}" class="card p-3 mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label>Назва:</label>
                    <input type="text" name="task_name" class="form-control"
                           value="{{ $filters['task_name'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label>Папка:</label>
                    <select name="folder_id" class="form-select">
                        <option value="">Будь-яка</option>
                        @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}" {{ ($filters['folder_id'] ?? '') == $folder->id ? 'selected' : '' }}>
                                {{ $folder->folder_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Статус:</label>
                    <select name="status" class="form-select">
                        <option value="">Будь-який</option>
                        <option value="Очікує" {{ ($filters['status'] ?? '') === 'Очікує' ? 'selected' : '' }}>Очікує</option>
                        <option value="У процесі" {{ ($filters['status'] ?? '') === 'У процесі' ? 'selected' : '' }}>У процесі</option>
                        <option value="Завершено" {{ ($filters['status'] ?? '') === 'Завершено' ? 'selected' : '' }}>Завершено</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Пріоритет:</label>
                    <select name="priority" class="form-select">
                        <option value="">Будь-який</option>
                        <option value="Низький" {{ ($filters['priority'] ?? '') === 'Низький' ? 'selected' : '' }}>Низький</option>
                        <option value="Середній" {{ ($filters['priority'] ?? '') === 'Середній' ? 'selected' : '' }}>Середній</option>
                        <option value="Високий" {{ ($filters['priority'] ?? '') === 'Високий' ? 'selected' : '' }}>Високий</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Дедлайн:</label>
                    <input type="date" name="deadline" class="form-control"
                           value="{{ $filters['deadline'] ?? '' }}">
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">Застосувати</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Очистити</a>
            </div>
        </form>

        {{-- Таблиця завдань --}}
        @if ($tasks->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Назва</th>
                        <th>Папка</th>
                        <th>Статус</th>
                        <th>Пріоритет</th>
                        <th>Дедлайн</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->folder->folder_name ?? 'Без папки' }}</td>
                            <td>
                                @if ($task->status === 'Завершено')
                                    <span class="badge bg-success">Завершено</span>
                                @elseif ($task->status === 'У процесі')
                                    <span class="badge bg-warning text-dark">У процесі</span>
                                @else
                                    <span class="badge bg-secondary">Очікує</span>
                                @endif
                            </td>
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->formatted_deadline ?? '—' }}</td>
                            <td>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-primary">Редагувати</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Видалити це завдання?')">Видалити</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Завдань ще немає. Створіть перше!</p>
        @endif
    </div>
@endsection
