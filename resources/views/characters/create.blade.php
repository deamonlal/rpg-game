@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Создать персонажа</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="character-card p-4">
                    <form action="{{ route('characters.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя персонажа</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Скрытые поля с дефолтными значениями -->
                        <input type="hidden" name="level" value="1">
                        <input type="hidden" name="exp" value="0">
                        <input type="hidden" name="gold" value="0">
                        <input type="hidden" name="health" value="10">

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">🚀 Создать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 back-characters">
            <a href="{{ route('characters.index') }}" class="btn btn-secondary">⬅ Назад к списку персонажей</a>
        </div>
    </div>

    <style>
        .character-card {
            background: #ffffff;
            border: 2px solid #007bff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s ease;
            max-width: 600px; /* Ограничение ширины карточки */
            margin: 0 auto; /* Центрируем карточку */
            padding: 25px;
        }

        .character-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .character-card .form-label {
            font-weight: bold;
            color: #007bff;
        }

        .form-control {
            padding: 10px;
            font-size: 1.1rem;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            background-color: #007bff;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .btn-secondary:hover {
            background-color: #6c757d;
        }

        .back-characters {
            margin-top: 30px;
        }
    </style>
@endsection
