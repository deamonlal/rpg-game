@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Создать персонажа</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="character-card p-4">
                    <form action="{{ route('character.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">Имя персонажа</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('characters.index') }}" class="btn btn-secondary">Назад к списку персонажей</a>
        </div>
    </div>

    <style>
        .character-card {
            background: #ffffff; /* Белый фон */
            border: 2px solid #007bff; /* Синяя рамка */
            border-radius: 15px; /* Закругленные углы */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Тень */
            transition: transform 0.3s, box-shadow 0.3s ease; /* Плавные переходы */
            cursor: pointer; /* Указатель мыши изменится на "руку" */
            overflow: hidden; /* Скрываем излишки */
        }

        .character-card:hover {
            transform: translateY(-5px); /* Легкий подъем при наведении */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2); /* Увеличиваем тень при наведении */
        }

        .character-card .form-label {
            font-weight: bold;
            color: #007bff;
        }

        .text-center button {
            width: 100%;
            padding: 12px;
            font-size: 1.2rem;
        }

        .btn-secondary {
            padding: 10px 20px;
            font-size: 1rem;
        }
    </style>
@endsection
