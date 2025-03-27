@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">🎒 Инвентарь</h1>

        <div class="text-center mt-4">
            <a href="/game/?character_id={{ $characterId }}" class="btn btn-secondary">Назад</a>
        </div>

        <div class="inventory-container">
            @foreach ($items ?? [] as $item)
                <div class="inventory-card p-4 clickable-card"
                    data-character-id="{{ $characterId }}"
                    data-item-id="{{ $item['id'] }}"
                    data-item-slot="{{ $item['weapon']['slot'] ?? $item['armor']['slot'] ?? null }}"
                    data-item-equipped="{{ $item['is_equipped'] ? 'true' : 'false' }}">

                    <div class="inventory-header">
                        <h3>{{ $item['name'] }}</h3>
                    </div>
                    <div class="inventory-body">
                        <p><strong>Тип:</strong> {{ $item['type'] }}</p>
                        <p><strong>Редкость:</strong> <span class="rarity {{ strtolower($item['tier']['description']) }}">{{ $item['tier']['description'] }}</span></p>
                        <p><strong>Описание:</strong> {{ $item['description'] }}</p>
                        <p><strong>Количество:</strong> {{ $item['quantity'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.clickable-card').forEach(card => {
                card.addEventListener('click', function () {
                    let characterId = this.getAttribute('data-character-id');
                    let itemId = this.getAttribute('data-item-id');
                    let slot = this.getAttribute('data-item-slot');
                    let isEquipped = this.getAttribute('data-item-equipped') === 'true'

                    if (!isEquipped) {
                        fetch('/equipment', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Защита от CSRF
                            },
                            body: JSON.stringify({
                                character_id: characterId,
                                item_id: itemId,
                                slot: slot
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Предмет экипирован!');
                                    // Обновляем значение на клиенте из ответа от сервера
                                    this.setAttribute('data-item-equipped', 'true');

                                    // Обновляем интерфейс – выводим текст "Экипировано"
                                    let body = this.querySelector('.inventory-body');
                                    if (!this.querySelector('.equipped-text')) {
                                        let equippedText = document.createElement('p');
                                        equippedText.classList.add('equipped-text');
                                        equippedText.textContent = 'Экипировано';
                                        body.appendChild(equippedText);
                                    }
                                } else {
                                    alert('Ошибка: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Ошибка:', error));
                    } else {
                        fetch('/equipment', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                character_id: characterId,
                                slot: slot,
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Предмет снят!');
                                    this.setAttribute('data-item-equipped', 'false');
                                    let equippedText = this.querySelector('.equipped-text');
                                    if (equippedText) {
                                        equippedText.remove();
                                    }
                                } else {
                                    alert('Ошибка: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Ошибка:', error));
                    }
                });
            });
        });
    </script>

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
