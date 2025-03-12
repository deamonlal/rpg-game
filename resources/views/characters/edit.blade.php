@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Редактирование персонажа</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="character-card p-4">
                    <!-- Форма для редактирования имени персонажа -->
                    <form action="/character/{{ $character->id }}" method="POST">
                        @csrf
                        @method('POST') <!-- Используем POST для отправки данных -->

                        <div class="mb-4">
                            <label for="name" class="form-label">Имя персонажа</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $character->name }}" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary custom-btn">Сохранить изменения</button>
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
        /* Карточка для формы */
        .character-card {
            background: #ffffff; /* Белый фон */
            border: 2px solid #007bff; /* Синяя рамка */
            border-radius: 15px; /* Закругленные углы */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Тень */
            cursor: default; /* Убираем указатель руки */
            overflow: hidden; /* Скрываем излишки */
            max-width: 500px; /* Ограничиваем максимальную ширину */
            margin: 0 auto; /* Центрируем карточку */
            padding: 20px;
        }

        .character-card .form-label {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px; /* Отступ снизу */
        }

        .character-card .form-control {
            margin-bottom: 20px; /* Добавляем отступ снизу для поля ввода */
        }

        /* Кнопка "Сохранить изменения" */
        .custom-btn {
            width: 80%; /* Уменьшаем ширину кнопки */
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 25px; /* Скругляем углы */
            background-color: #007bff;
            color: white;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Стиль для кнопки при наведении */
        .custom-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Легкий подъем при наведении */
        }

        .custom-btn:focus {
            outline: none; /* Убираем фокусное кольцо */
        }

        .btn-secondary {
            padding: 10px 20px;
            font-size: 1rem;
        }

        /* Мобильная адаптивность */
        @media (max-width: 768px) {
            .character-card {
                width: 100%;
                padding: 20px;
            }

            .custom-btn {
                font-size: 1rem;
                width: 100%; /* Кнопка будет занимать всю ширину на мобильных устройствах */
            }

            .btn-secondary {
                font-size: 1rem;
            }
        }
    </style>
@endsection
