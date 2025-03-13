@extends('layouts.app')

@section('content')
    <div class="character-info">
        <h1>------</h1>
        <p>Персонаж: <strong>{{ $character->name }}</strong> (Уровень <strong>{{ $character->level }}</strong>)</p>

        <div class="actions">
            <a href="/fight" class="btn">Отправиться на поиски монстра</a>
            <a href="/inventory" class="btn btn-secondary">Найти торговца</a>
        </div>

        <!-- Новая кнопка выбора другого персонажа -->
        <div class="mt-3">
            <a href="/" class="btn btn-danger">🔄 Выбрать другого персонажа</a>
        </div>

        @if(session('message'))
            <p class="message">{{ session('message') }}</p>
        @endif
    </div>
@endsection

<style>
    .character-info {
        text-align: center;
        padding: 20px;
    }

    .actions {
        margin-top: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 5px;
        text-decoration: none;
        color: white;
        background-color: #28a745;
        border-radius: 5px;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn:hover {
        background-color: #218838;
    }

    .btn-secondary {
        background-color: #007bff;
    }

    .btn-secondary:hover {
        background-color: #0056b3;
    }

    /* Стиль новой кнопки */
    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .message {
        margin-top: 15px;
        padding: 10px;
        background-color: #f8d7da;
        color: #721c24;
        border-radius: 5px;
        display: inline-block;
    }

    .mt-3 {
        margin-top: 15px;
    }
</style>
