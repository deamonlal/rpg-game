<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentDestroyRequest;
use App\Http\Requests\EquipmentIndexRequest;
use App\Http\Requests\EquipmentStoreRequest;
use App\Models\Character;
use App\Models\Equipment;
use App\Models\Item;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EquipmentController extends Controller
{
    public function index(EquipmentIndexRequest $request): Application|Factory|View
    {
        $data = $request->validated();
        $equipment = Equipment::where('character_id', $data['character_id'])->get()->toArray();

        return view('character.index', compact('equipment'));
    }

    public function store(EquipmentStoreRequest $request): false|string
    {
        $data = $request->validated();

        $character = Character::find($data['character_id']);

        $character->equipment()->updateOrCreate(
            ['slot' => $data['slot']],
            ['item_id' => $data['item_id']]
        );

        $item = Item::find($data['item_id']);
        $item->is_equipped = true;
        $item->save();


        return json_encode(['success' => true]);
    }

    public function update(Request $request)
    {

    }

    public function destroy(EquipmentDestroyRequest $request): false|string
    {
        $data = $request->validated();
        $character = Character::find($data['character_id']);
        $character->equipment()->where('slot', $data['slot'])->delete();
        return json_encode(['success' => true]);
    }
}
