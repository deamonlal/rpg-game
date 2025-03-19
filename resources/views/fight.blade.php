@extends('layouts.app')

@section('content')
    <div class="battle-container">
        <h1>Вы встретили <span id="enemy-name">{{$enemy['name']}}</span></h1>

        <div class="battle-info">
            <div class="character-box hero">
                <h2>{{$character['name']}}</h2>
                <p>❤️ Очки здоровья: <span id="hero-health">{{$character['health']}}</span></p>
                <p>⚔️ Сила удара: <span id="hero-damage">1</span> (Уровень {{ $character['level'] }})</p>
            </div>

            <div class="character-box enemy">
                <h2>{{$enemy['name']}}</h2>
                <p>❤️ Очки здоровья: <span id="enemy-health">{{$enemy['health']}}</span></p>
                <p>⚔️ Сила удара: <span id="enemy-damage">{{ $enemy['damage'] }}</span> (Уровень {{ $enemy['level'] }})</p>
            </div>
        </div>

        <div class="battle-actions">
            <button id="attack-btn" class="btn btn-danger">⚔️ Атаковать монстра</button>
            <button id="run-btn" class="btn btn-warning">🏃‍♂️ Попытаться убежать</button>
        </div>

        <p id="battle-log"></p>
        <div id="result"></div> <!-- Сообщение о победе/поражении -->

        @if(session('message'))
            <p class="message">{{ session('message') }}</p>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        let heroLevel = {{ $character['level'] }};
        let heroHealth = {{ $character['health'] }};
        let heroDamage = 1;
        let heroExp = {{ $character['exp'] }};
        let heroGold = {{ $character['gold'] }};
        let heroInventory = JSON.parse('{{ $character['inventory'] ?? '{}' }}'.replace(/&quot;/g,'"'));
        let enemyLevel = {{ $enemy['level'] }};
        let enemyExpGain = {{ $enemy['exp_gain'] }};
        let enemyHealth = {{ $enemy['health'] }};
        let enemyDamage = {{ $enemy['damage'] }};
        let enemyItems = JSON.parse('{{ $enemy['items'] ?? json_encode([]) }}'.replace(/&quot;/g,'"'));

        document.getElementById("attack-btn").addEventListener("click", attackMonster);
        document.getElementById("run-btn").addEventListener("click", tryToRun);

        function attackMonster() {
            if (enemyHealth <= 0 || heroHealth <= 0) return;
            let isEnemyDead = heroPunch();
            if (isEnemyDead) {
                return;
            }
            enemyPunch();
        }

        function tryToRun() {
            let levelRatio = heroLevel / enemyLevel;

            if (levelRatio >= 1 || Math.random() < levelRatio) {
                window.location.href = "/game?character_id={{$character['id']}}";
                return;
            }

            enemyPunch();
        }

        function heroPunch() {
            // Герой атакует
            enemyHealth -= heroDamage;
            document.getElementById("enemy-health").innerText = enemyHealth;

            if (enemyHealth <= 0) {
                document.getElementById("battle-log").innerText = "Вы победили!";
                document.getElementById("attack-btn").style.display = "none";
                document.getElementById("run-btn").style.display = "none";

                heroExp += enemyExpGain;
                let items = checkEnemyItems();
                checkHeroLevelUp()


                Object.entries(items).forEach(([key, value]) => {
                    // Если предмет уже есть в инвентаре, увеличиваем его количество
                    if (heroInventory[key]) {
                        heroInventory[key] += value;
                    } else {
                        // Если предмета нет, добавляем его с количеством value
                        heroInventory[key] = value;
                    }
                });

                fetch("/characters/{{ $character['id'] }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        'name': '{{ $character['name'] }}',
                        'level': heroLevel,
                        'exp': heroExp,
                        'gold': heroGold,
                        'health': heroHealth,
                        'inventory': JSON.stringify(heroInventory),
                        'skills': '{{ $character['skills'] ?? json_encode([]) }}'
                    })
                })

                let itemString = ``;

                if (Object.keys(items).length > 0) {
                    // Преобразуем объект items в строку для отображения
                    const itemList = Object.entries(items)
                        .map(([key, value]) => `<b>${key}</b>`)
                        .join(", "); // Соединяем элементы через запятую

                    itemString = `<p>Вы получили предметы: ${itemList}!</p>`;
                }

                document.getElementById("result").innerHTML = itemString + `<button onclick="window.location.href='/game?character_id={{$character['id']}}'" class="btn btn-success">🏠 Вернуться назад</button>`;

                return true;
            }
            return false;
        }

        function enemyPunch() {
            // Враг атакует
            heroHealth -= enemyDamage;
            document.getElementById("hero-health").innerText = heroHealth;

            if (heroHealth <= 0) {
                document.getElementById("battle-log").innerText = "Вы были повержены!";
                document.getElementById("attack-btn").style.display = "none";
                document.getElementById("run-btn").style.display = "none";
                document.getElementById("result").innerHTML = `<p>Ваш персонаж удален.</p>`;

                fetch('{{ route('characters.destroy', $character['id']) }}', {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(() => setTimeout(() => window.location.href = "/", 2000));
                return true;
            }
            return false;
        }

        function checkEnemyItems() {
            let items = {};
            Object.entries(enemyItems).forEach(([key, chance]) => {
                const random = Math.floor(Math.random() * 100) + 1;
                if (random <= chance) {
                    if (key in heroInventory) {
                        items[key] = (items[key] || 0) + 1;
                    } else {
                        items[key] = 1;
                    }
                }
            });

            return items;
        }

        function checkHeroLevelUp() {
            // Сначала определяем, сколько опыта требуется для каждого уровня
            const startExpLevel = 15;
            let neededExp;
            while (heroExp >= (neededExp = startExpLevel * Math.pow(1 + 0.2, heroLevel - 1))) {
                // Если опыта достаточно для текущего уровня
                alert('Вы получили новый уровень!');
                heroExp -= neededExp; // Вычитаем опыт, потраченный на текущий уровень
                heroLevel += 1; // Увеличиваем уровень
                heroHealth *= 1.3; // Увеличиваем здоровье
                heroDamage += 1; // Увеличиваем урон
            }
        }
    </script>
@endpush

<style>
    .battle-container {
        text-align: center;
        padding: 20px;
        background: #f4f4f4;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    .battle-info {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
    }

    .character-box {
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        width: 45%;
    }

    .hero {
        background: #d4edda;
        border: 2px solid #28a745;
    }

    .enemy {
        background: #f8d7da;
        border: 2px solid #dc3545;
    }

    .battle-actions {
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        margin: 5px;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-warning {
        background: #ffc107;
        color: black;
        border: none;
    }

    .btn-warning:hover {
        background: #e0a800;
    }

    .btn-success {
        background: #28a745;
        color: white;
        border: none;
    }

    .btn-success:hover {
        background: #218838;
    }

    .message {
        margin-top: 15px;
        padding: 10px;
        background-color: #f8d7da;
        color: #721c24;
        border-radius: 5px;
        display: inline-block;
    }

    @media (max-width: 768px) {
        .battle-info {
            flex-direction: column;
            align-items: center;
        }

        .character-box {
            width: 80%;
            margin-bottom: 15px;
        }
    }
</style>
