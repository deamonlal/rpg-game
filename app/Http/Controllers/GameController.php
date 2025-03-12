<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $character = Character::firstOrCreate([
            'name' => 'Герой',
            'level' => '1',
            'exp' => '0',
            'gold' => '0',
            'health' => '10',
            'inventory' => json_encode([]),
            'skills' => json_encode([]),
        ]);

        return view('game', compact('character'));
    }

    public function walk(WalkRequest $request) {
        $data = $request->validated();
    }

    public function fight() {
        $character = Character::find(['id' => 1])->toArray()[0];
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
