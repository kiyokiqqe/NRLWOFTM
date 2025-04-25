@extends('layouts.app')

@section('title', 'Task Manager')

@section('content')
    
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    <div class="background-image"></div>

    <div class="container py-5 position-relative">
        <div class="hero-section row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h1 class="hero-title">Task Manager</h1>
                <p class="hero-subtitle mt-3">
                    Керуйте своїми завданнями легко і швидко.<br>
                    Відстежуйте дедлайни, статуси і пріоритети – все в одному місці.
                </p>

                @if (Auth::check())
                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Перейти до кабінету</a>
                    </div>
                @else
                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary">Увійти</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Зареєструватися</a>
                    </div>
                @endif
            </div>


            <div class="col-md-6 text-center">
                <img src="https://media.istockphoto.com/id/1370888403/it/foto/designer-uomini-che-puntano-la-pianificazione-delle-note-stilizzate-sviluppare-applicazioni.jpg?s=612x612&w=0&k=20&c=XH62GmfLinRIo2BSrmRAjzWTEZDHF5dqf3CbiaCrJ4Q=" 
                     alt="Task Manager" class="img-preview">
            </div>
        </div>
    </div>
@endsection
