<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameIndexRequest;
use App\Models\Character;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(GameIndexRequest $request)
    {
        $data = $request->validated();
        $character = Character::find($data['character_id']);

        return view('game', compact('character'));
    }

    public function walk(WalkRequest $request) {
        $data = $request->validated();
    }

    public function fight() {
        $character = Character::find(['id' => 1]);
        $enemy = [
            'name' => 'Павук',
            'level' => 1,
            'damage' => 1,
            'health' => 3,
        ];
        return view('fight', ['enemy' => $enemy, 'character' => $character]);
    }

    public function punch(PunchRequest $request) {
        $character = Character::first(['name' => 'Герой'])->toArray();
        $enemy = [
            'name' => 'Павук',
            'level' => 1,
            'damage' => 1,
            'health' => 3,
        ];

        return view('fight');
    }

    public function leaveFight(LeaveFightRequest $request) {

    }

    public function trade(TradeRequest $request) {
        $data = $request->validated();
    }
}
