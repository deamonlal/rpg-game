@extends('layouts.app')

@section('content')
    <h1>Вы встретили <span id="enemy-name">{{$enemy['name']}}</span></h1>

    <h2>{{$character['name']}}:</h2>
    <p>Очки здоровья: <span id="hero-health">{{$character['health']}}</span></p>
    <p>Сила удара: <span id="hero-damage">1</span> (Уровень {{ $character['level'] }})</p>

    <h2>{{$enemy['name']}}:</h2>
    <p>Очки здоровья: <span id="enemy-health">{{$enemy['health']}}</span></p>
    <p>Сила удара: <span id="enemy-damage">{{ $enemy['damage'] }}</span> (Уровень {{ $enemy['level'] }})</p>

    <button id="attack-btn">Атаковать монстра</button>
    <a href="/run">Попытаться убежать</a>

    <p id="battle-log"></p>
    <div id="result"></div> <!-- Здесь будет сообщение о победе/поражении -->

    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif
@endsection

@push('scripts')
    <script>
        // 🟢 Получаем данные из Blade в JS
        let heroHealth = {{ $character['health'] }};
        let heroDamage = 1; // Можно сделать динамическим
        let enemyHealth = {{ $enemy['health'] }};
        let enemyDamage = {{ $enemy['damage'] }};

        document.getElementById("attack-btn").addEventListener("click", function () {
            attackMonster();
        });

        function attackMonster() {
            if (enemyHealth <= 0 || heroHealth <= 0) {
                return;
            }

            // 🟢 Герой атакует врага
            enemyHealth -= heroDamage;
            document.getElementById("enemy-health").innerText = enemyHealth;

            // 🛑 Если враг побежден
            if (enemyHealth <= 0) {
                document.getElementById("battle-log").innerText = "Вы победили!";
                document.getElementById("attack-btn").style.display = "none";

                // 🎁 Генерируем предмет
                let item = "Меч героя"; // Можно сделать случайным
                document.getElementById("result").innerHTML = `
                    <p>Вы получили предмет: <b>${item}</b>!</p>
                    <button onclick="window.location.href='/'">Вернуться назад</button>
                `;

                // 🟢 Отправляем запрос на сохранение предмета
                fetch('/item/collect', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ item: item })
                });

                // 🟢 Обновляем параметры героя
                fetch('/hero/1/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ heroHealth: heroHealth })
                });

                return;
            }

            // 🔴 Враг атакует героя
            heroHealth -= enemyDamage;
            document.getElementById("hero-health").innerText = heroHealth;

            // ☠️ Если герой погиб
            if (heroHealth <= 0) {
                document.getElementById("battle-log").innerText = "Вы были повержены!";
                document.getElementById("attack-btn").style.display = "none";
                document.getElementById("result").innerHTML = `<p>Ваш персонаж удален.</p>`;

                // ☠️ Отправляем запрос на удаление героя
                fetch('/hero/1/delete', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    setTimeout(() => {
                        window.location.href = "/"; // Перенаправление на главную
                    }, 2000);
                });
            }
        }
    </script>
@endpush
