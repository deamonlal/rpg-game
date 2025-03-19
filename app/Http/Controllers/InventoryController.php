<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryIndexRequest;
use App\Models\Character;
use App\Models\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(InventoryIndexRequest $request)
    {
        $data = $request->validated();
        $inventoryJson = Character::find($data['character_id'])->inventory;
        $items = json_decode($inventoryJson, true);
        $itemKeys = array_keys($items);
        $itemsWithDescription = Item::whereIn('name', $itemKeys)->with('tier')->get(['name', 'description', 'type', 'tier_id'])->toArray();

        $typeMap = [
            'armors' => 'Броня',
            'weapons' => 'Оружие',
            'alchemy' => 'Алхимия',
            'items' => 'Предмет',
            // Добавляйте новые типы предметов здесь
        ];


        foreach ($itemsWithDescription as &$item) {
            // Используем тип из маппинга, если он есть
            if (isset($typeMap[$item['type']])) {
                $item['type'] = $typeMap[$item['type']];
            }

            if (isset($items[$item['name']])) {
                $item['quantity'] = $items[$item['name']];
            }
        }

        return view('inventories.index', ['items' => $itemsWithDescription, 'characterId' => $data['character_id']]);
    }
}
