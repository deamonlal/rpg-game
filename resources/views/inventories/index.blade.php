@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">🎒 Инвентарь</h1>
        <div class="inventory-container">
            @foreach ($items ?? [] as $item)
                <div class="inventory-card p-4">
                    <div class="inventory-header">
                        <h3>{{ $item->name }}</h3>
                    </div>
                    <div class="inventory-body">
                        <p><strong>Тип:</strong> {{ $item->type }}</p>
{{--                        <p><strong>Редкость:</strong> <span class="rarity {{ strtolower($item->tier) }}">{{ $item->rarity }}</span></p>--}}
{{--                        <p><strong>Описание:</strong> {{ $item->description }}</p>--}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .inventory-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .inventory-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }
        .inventory-card:hover {
            transform: scale(1.05);
        }
        .inventory-header {
            background: #007bff;
            color: white;
            padding: 10px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            text-align: center;
        }
        .inventory-body {
            padding: 15px;
        }
        .rarity.common { color: gray; }
        .rarity.rare { color: blue; }
        .rarity.epic { color: purple; }
        .rarity.legendary { color: gold; font-weight: bold; }
    </style>
@endsection
