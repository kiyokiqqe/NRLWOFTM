@extends('layouts.app')

@section('title', 'Увійти')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4 text-center">Увійти в акаунт</h2>

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

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email адреса</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember_me">
                    Запам'ятати мене
                </label>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    Увійти
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
