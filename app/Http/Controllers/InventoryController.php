<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryIndexRequest;
use App\Services\InventoryService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function __construct(protected InventoryService $inventoryService)
    {}

    public function index(InventoryIndexRequest $request): Application|View|Factory|RedirectResponse
    {
        $data = $request->validated();
        $characterId = $data['character_id'];

        try {
            $inventoryItems = $this->inventoryService->getInventoryItems($characterId);
            $itemsWithDescription = $this->inventoryService->getItemsCollection(array_keys($inventoryItems));
            $mappedItems = $this->inventoryService->mapItemsWithDescription($itemsWithDescription, $inventoryItems);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('error.page')->withErrors('Ошибка получения предметов!');
        }

        return view('inventories.index', [
            'items' => $mappedItems,
            'characterId' => $characterId
        ]);
    }
}
