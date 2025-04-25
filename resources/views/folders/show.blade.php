@extends('layouts.app')

@section('title', 'Завдання у папці: ' . $folder->folder_name)

@section('content')
    <h1>Завдання у папці: {{ $folder->folder_name }}</h1>

    <a href="{{ route('tasks.create', ['folder_id' => $folder->id]) }}" class="btn btn-primary mb-3">
        ➕ Додати завдання до цієї папки
    </a>

    @if ($tasks->isEmpty())
        <p>У цій папці поки немає завдань.</p>
    @else
        <ul class="list-group">
            @foreach ($tasks as $task)
                <li class="list-group-item">
                    <strong>{{ $task->task_name }}</strong><br>
                    {{ $task->task_description }}<br>
                    <small>
                        Статус:
                        @if ($task->status === 'Завершено')
                            <span class="badge bg-success">Завершено</span>
                        @elseif ($task->status === 'У процесі')
                            <span class="badge bg-warning text-dark">У процесі</span>
                        @else
                            <span class="badge bg-secondary">Очікує</span>
                        @endif
                        |
                        Пріоритет:
                        @if ($task->priority === 'Високий')
                            <span class="badge bg-danger">Високий</span>
                        @elseif ($task->priority === 'Середній')
                            <span class="badge bg-warning">Середній</span>
                        @else
                            <span class="badge bg-info">Низький</span>
                        @endif
                        |
                        До: {{ $task->deadline }}
                    </small>
                    <div class="mt-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Редагувати</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Видалити</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('folders.index') }}" class="btn btn-secondary mt-3">Назад до списку папок</a>
@endsection
