@extends('layouts.app')

@section('title', 'Реєстрація')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4 text-center">Реєстрація нового користувача</h2>

        {{-- Виведення помилок --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Ім'я</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email адреса</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Підтвердження паролю</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-link" href="{{ route('login') }}">
                    Вже маєте акаунт?
                </a>

                <button type="submit" class="btn btn-success">
                    Зареєструватися
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
