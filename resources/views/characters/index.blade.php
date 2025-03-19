@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Список персонажей</h1>

        <!-- Кнопка создания персонажа -->
        <div class="text-center mb-4 character-create">
            <a href="/characters/create" class="btn btn-success btn-lg">➕ Создать персонажа</a>
        </div>

        <!-- Контейнер карточек -->
        <div class="characters-container">
            @foreach ($characters as $character)
                <div class="character-card-wrapper">
                    <!-- Кликабельная карточка -->
                    <a href="/game?character_id={{ $character->id }}" class="character-card-link">
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
                                    @foreach (json_decode($character->inventory ?? "{}", true) as $item => $value)
                                        <li class="list-group-item">{{ $item }} - {{ $value }} шт.</li>
                                    @endforeach
                                </ul>

                                <h5 class="text-success">⚡ Способности:</h5>
                                <ul class="list-group">
                                    @foreach (json_decode($character->skills ?? "{}", true) as $skill)
                                        <li class="list-group-item">{{ $skill }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </a>

                    <!-- Кнопка удаления персонажа -->
                    <form action="{{ route('characters.destroy', $character->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete" onclick="return confirmDelete()">
                            ❌ Удалить
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Вы уверены, что хотите удалить этого персонажа? Это действие нельзя отменить!");
        }
    </script>

    <style>
        /* Контейнер карточек - делает их в одну линию */
        .characters-container {
            margin-left: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Отступы между карточками */
            justify-content: flex-start; /* Центрируем карточки */
        }

        /* Обертка карточки и кнопки */
        .character-card-wrapper {
            flex: 1 1 400px; /* Минимальный размер 300px, равномерное распределение */
            max-width: 400px; /* Максимальная ширина */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .character-card-link {
            text-decoration: none;
            display: block;
            width: 100%;
        }

        .character-card {
            background: #ffffff;
            border: 2px solid #007bff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s ease;
            cursor: pointer;
            overflow: hidden;
        }

        .character-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .character-header {
            background: #007bff;
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

        .character-create {
            margin-bottom: 25px;
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

        .btn-success {
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Кнопка удаления */
        .btn-delete {
            margin-top: 10px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Для мобильных уменьшаем размер карточек */
        @media (max-width: 768px) {
            .characters-container {
                justify-content: center;
            }

            .character-card-wrapper {
                flex: 1 1 100%;
            }
        }
    </style>
@endsection
