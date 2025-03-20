<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentStoreRequest;
use App\Models\Character;
use App\Models\Equipment;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(EquipmentIndexRequest $request)
    {
        $data = $request->validated();
        $equipment = Equipment::where('character_id', $data['character_id'])->get()->toArray();

        return view('character.index', compact('equipment'));
    }

    public function store(EquipmentStoreRequest $request)
    {
        $data = $request->validated();

        $character = Character::find($data['character_id']);

        $character->equipment()->updateOrCreate(
            ['slot' => $data['slot']],
            ['item_id' => $data['item_id']]
        );

        return redirect()->route('inventory.index');
    }

    public function update(Request $request)
    {

    }

    public function destroy(EquipmentDestroyRequest $request)
    {
        $data = $request->validated();
        $character = Character::find($data['character_id']);
        $character->equipment()->where('slot', $data['slot'])->delete();
        return redirect()->route('inventory.index');
    }
}
