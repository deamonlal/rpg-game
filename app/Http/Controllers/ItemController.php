<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemStoreRequest;
use App\Services\ItemService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ItemController extends Controller
{
    public function __construct(protected ItemService $itemService) {}

    public function index(): Application|Factory|View
    {
        $items = $this->itemService->getAllItems();
        return view('items.index', compact('items'));
    }

    public function create(): View|Factory|Application
    {
        return view('items.create');
    }

    public function store(ItemStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $item = $this->itemService->createItem($validated);
        $this->itemService->createItemTypeSpecific($item, $validated);

        return redirect()->route('items.index')->with('success', 'Предмет добавлен!');
    }
}
