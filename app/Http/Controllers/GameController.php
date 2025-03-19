<?php

namespace App\Http\Controllers;

use App\Http\Requests\FightRequest;
use App\Http\Requests\GameIndexRequest;
use App\Models\Character;
use App\Models\Enemy;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(GameIndexRequest $request): Factory|View|Application|RedirectResponse
    {
        $data = $request->validated();
        $character = Character::getById($data['character_id']);

        if (!$character) {
            return redirect()->route('error.page')->withErrors('Персонаж не найден.');
        }

        return view('game', compact('character'));
    }

    public function fight(FightRequest $request): Application|Factory|View|RedirectResponse
    {
        $data = $request->validated();
        $character = Character::getById($data['character_id']);

        if (!$character) {
            return redirect()->route('error.page')->withErrors('Персонаж не найден.');
        }

        $enemy = Enemy::getRandomByTier($data['location_tier']);

        if (!$enemy) {
            return redirect()->route('error.page')->withErrors('Враг не найден.');
        }

        return view('fight', ['enemy' => $enemy, 'character' => $character]);
    }
}
