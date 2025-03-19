<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Weapon;
use App\Models\Armor;
use App\Models\Tier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['weapon', 'armor', 'tier'])->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $tier = Tier::firstOrCreate(['tier' => $request->tier]);

        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'tier_id' => $tier->id
        ]);

        if ($request->type === 'weapon') {
            Weapon::create([
                'item_id' => $item->id,
                'damage' => $request->damage
            ]);
        } elseif ($request->type === 'armor') {
            Armor::create([
                'item_id' => $item->id,
                'armor' => $request->armor
            ]);
        }

        return redirect()->route('items.index')->with('success', 'Предмет добавлен!');
    }
}
