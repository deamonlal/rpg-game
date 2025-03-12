@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Список персонажей</h1>

        <div class="row">
            @foreach ($characters as $character)
                <div class="col-md-4 mb-4">
                    <!-- Сделаем карточку кликабельной, добавив ссылку -->
                    <a href="/characters/{{ $character->id }}/edit" class="character-card-link">
                        <div class="character-card p-4">
                            <div class="character-header">
                                <h3>{{ $character->name }}</h3>
                            </div>
                            <div class="character-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>Уровень:</strong> {{ $character->level }}</p>
                                        <p><strong>Опыт:</strong> {{ $character->exp }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>Золото:</strong> {{ $character->gold }}</p>
                                        <p><strong>Здоровье:</strong> {{ $character->health }}</p>
                                    </div>
                                </div>

                                <hr>

                                <h5 class="text-primary">🎒 Инвентарь:</h5>
                                <ul class="list-group mb-3">
                                    @foreach (json_decode($character->inventory, true) as $item)
                                        <li class="list-group-item">{{ $item }}</li>
                                    @endforeach
                                </ul>

                                <h5 class="text-success">⚡ Способности:</h5>
                                <ul class="list-group">
                                    @foreach (json_decode($character->skills, true) as $skill)
                                        <li class="list-group-item">{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        /* Убираем подчеркивание у ссылок */
        .character-card-link {
            text-decoration: none;
            display: block;
        }

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
            transform: translateY(-10px); /* Легкий подъем при наведении */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2); /* Увеличиваем тень при наведении */
        }

        .character-header {
            background: #007bff; /* Синяя зона заголовка */
            color: white;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .character-body {
            padding: 20px;
        }

        .character-body p {
            margin-bottom: 10px;
        }

        .list-group-item {
            background-color: #f8f9fa;
            border: none;
            padding: 8px 16px;
        }

        .list-group-item:not(:last-child) {
            margin-bottom: 5px;
        }

        .text-primary {
            font-weight: bold;
            color: #007bff;
        }

        .text-success {
            font-weight: bold;
            color: #28a745;
        }

        /* Уменьшаем карточки для мобильных */
        @media (max-width: 768px) {
            .character-card {
                max-width: 100%;
            }

            .character-header h3 {
                font-size: 1.2rem;
            }
        }
    </style>
@endsection
