@extends('layouts.app')  

@section('title', 'Дашборд')

@section('content')
<div class="container py-4">

    {{-- Привітання при вході --}}
    @if(session('just_logged_in'))
        <div class="alert alert-success">
            <h1 class="h4">Привіт, {{ Auth::user()->name ?? 'Користувач' }}! 👋</h1>
            <p class="mb-0">Ласкаво просимо до свого менеджера завдань. Оберіть дію нижче 👇</p>
        </div>

        <div class="alert alert-info mt-2">
            💡 Порада: Ви можете фільтрувати завдання за статусом, пріоритетом або дедлайном прямо зі сторінки завдань.
        </div>

        @php
            session()->forget('just_logged_in');
        @endphp
    @endif

    {{-- Кнопки швидких дій --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('folders.index') }}" class="btn btn-outline-primary w-100 py-3">
                📁 Переглянути папки
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-success w-100 py-3">
                ✅ Усі завдання
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('folders.create') }}" class="btn btn-outline-warning w-100 py-3">
                ➕ Створити нову папку
            </a>
        </div>
    </div>

    {{-- Статистика --}}
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">Загальна кількість папок</h5>
                    <p class="card-text fs-3">{{ Auth::user()->folders()->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">Усього завдань</h5>
                    <p class="card-text fs-3">{{ Auth::user()->tasks()->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title">Невиконані завдання</h5>
                    <p class="card-text fs-3">{{ Auth::user()->tasks()->where('status', '!=', 'Завершено')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Список останніх завдань --}}
    <div class="mt-5">
        <h4>Останні завдання</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Назва</th>
                    <th>Статус</th>
                    <th>Пріоритет</th>
                    <th>Дедлайн</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Auth::user()->tasks()->latest()->take(5)->get() as $task)
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>
                            @if($task->status === 'Завершено')
                                <span class="badge bg-success">Завершено</span>
                            @elseif($task->status === 'У процесі')
                                <span class="badge bg-warning text-dark">У процесі</span>
                            @else
                                <span class="badge bg-secondary">Очікує</span>
                            @endif
                        </td>
                        <td>
                            @if($task->priority === 'Високий')
                                <span class="badge bg-danger">Високий</span>
                            @elseif($task->priority === 'Середній')
                                <span class="badge bg-warning">Середній</span>
                            @else
                                <span class="badge bg-info">Низький</span>
                            @endif
                        </td>
                        <td>{{ $task->formatted_deadline ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
