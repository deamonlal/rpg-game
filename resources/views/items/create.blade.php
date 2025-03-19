@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить предмет</h2>
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <label>Название:</label>
            <input type="text" name="name" required>

            <label>Описание:</label>
            <textarea name="description"></textarea>

            <label>Тип:</label>
            <select name="type" id="item-type">
                <option value="weapons">Оружие</option>
                <option value="armors">Броня</option>
                <option value="alchemy">Броня</option>
                <option value="items">Броня</option>
            </select>

            <label>Редкость (Tier):</label>
            <input type="number" name="tier" required>

            <div id="weapon-fields">
                <label>Урон:</label>
                <input type="number" name="damage">
            </div>

            <div id="armor-fields" style="display: none;">
                <label>Броня:</label>
                <input type="number" name="armor">
            </div>

            <button type="submit">Добавить</button>
        </form>
    </div>

    <script>
        document.getElementById('item-type').addEventListener('change', function() {
            document.getElementById('weapon-fields').style.display = this.value === 'weapon' ? 'block' : 'none';
            document.getElementById('armor-fields').style.display = this.value === 'armor' ? 'block' : 'none';
        });
    </script>
@endsection
