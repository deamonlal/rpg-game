<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryIndexRequest;
use App\Models\Character;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(InventoryIndexRequest $request)
    {
        $data = $request->validated();
        $inventoryJson = Character::find($data['character_id'])->inventory;
        $items = json_decode($inventoryJson, true);
        var_dump($items);

        return view('inventories.index', compact('items'));
    }
}
