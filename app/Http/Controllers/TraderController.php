<?php

namespace App\Http\Controllers;

use App\Http\Requests\TraderBuyRequest;
use App\Http\Requests\TraderIndexRequest;
use App\Http\Requests\TraderSellRequest;
use App\Models\Character;
use App\Models\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class TraderController extends Controller
{
    public const TRADER_MARKUP = 1.3;
    public const TRADER_DISCONT = 0.75;

    public function index(TraderIndexRequest $request): Application|Factory|View
    {
        $data = $request->validated();
        $character = Character::find($data['character_id'])->toArray();
        $traderItems = Item::inRandomOrder()->limit(5)->get()->toArray();
        $charItems = json_decode($character['inventory'], true);
        $charItemKeys = array_keys($charItems ?? []);
        $characterItems = Item::whereIn('name', $charItemKeys)->get()->toArray();

        return view('traders.index', compact('character', 'traderItems', 'characterItems'));
    }

    public function buy(TraderBuyRequest $request, Item $item): RedirectResponse
    {
        $data = $request->validated();
        $character = Character::find($data['character_id']);
        $money = $character->gold;
        $inventory = json_decode($character->inventory, true);
        $cost = $item->price * self::TRADER_MARKUP;

        if ($money >= $cost) {
            $money -= $cost;
            if (key_exists($item->name, $inventory)) {
                $inventory += 1;
            } else {
                $inventory[$item->name] = 1;
            }

            $character->gold = $money;
            $character->inventory = json_encode($inventory);
            $character->save();
        }

        return redirect()->route('trader');
    }

    public function sell(TraderSellRequest $request, Item $item): RedirectResponse
    {
        $data = $request->validated();
        $character = Character::find($data['character_id']);
        $money = $character->gold;
        $inventory = json_decode($character->inventory, true);
        $cost = $item->price * self::TRADER_DISCONT;

        if (key_exists($item->name, $inventory)) {
            $inventory[$item->name] -= 1;
            if ($inventory[$item->name] < 1) {
                unset($inventory[$item->name]);
            }
            $money += $cost;
        }

        $character->gold = $money;
        $character->inventory = json_encode($inventory);
        $character->save();

        return redirect()->route('trader');
    }
}
