@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">🛒 Торговец</h1>

        <!-- Отображение количества денег игрока -->
        <div class="alert alert-info text-center">
            <strong>💰 Ваши деньги:</strong> {{ number_format($character['gold'], 0, ',', ' ') }} монет
        </div>

        <!-- Секция товаров торговца -->
        <h3 class="text-center mb-3">📦 Товары у торговца</h3>
        <div class="items-container">
            @foreach ($traderItems as $item)
                <div class="item-card">
                    <h5 class="item-title">{{ $item['name'] }}</h5>
                    <p class="item-description">{{ $item['description'] }}</p>
                    <p><strong>🪙 Покупка:</strong> {{ number_format($item['price'] * 1.3, 0, ',', ' ') }} монет</p>

                    <form action="{{ route('trader.buy', $item['id']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="character_id" value="{{ $character['id'] }}">
                        <button type="submit" class="btn btn-success w-100" {{ $character['gold'] < 1 ? 'disabled' : '' }}>
                            🛍 Купить
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Разделитель -->
        <hr class="my-5">

        <!-- Секция предметов игрока -->
        <h3 class="text-center mb-3">🎒 Ваш инвентарь</h3>
        <div class="items-container">
            @foreach ($characterItems ?? [] as $item)
                <div class="item-card">
                    <h5 class="item-title">{{ $item['name'] }}</h5>
                    <p class="item-description">{{ $item['description'] }}</p>
                    <p><strong>🔻 Продажа:</strong> {{ number_format($item['price'] * 0.75, 0, ',', ' ') }} монет</p>

                    <form action="{{ route('trader.sell', $item['id']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="character_id" value="{{ $character['id'] }}">
                        <button type="submit" class="btn btn-danger w-100">
                            💰 Продать
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
        <!-- Кнопка "Вернуться назад" -->
        <div class="text-center mt-4">
            <a href="/game?character_id={{ $character['id'] }}" class="btn btn-primary btn-back">⬅ Вернуться назад</a>
        </div>
    </div>

    <style>
        .container {
            max-width: 1200px;
            margin: auto;
        }

        .items-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: left;
            gap: 15px;
        }

        .item-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            width: 220px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }

        .item-card:hover {
            transform: scale(1.05);
        }

        .item-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .item-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-back {
            background-color: #007bff;
            padding: 8px 16px;
            font-size: 16px;
            margin-bottom: 10px;
            margin-top: 25px;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
@endsection
