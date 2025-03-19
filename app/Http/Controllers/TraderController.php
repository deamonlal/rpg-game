<?php

namespace App\Http\Controllers;

use App\Http\Requests\TraderBuyRequest;
use App\Http\Requests\TraderIndexRequest;
use App\Http\Requests\TraderSellRequest;
use App\Models\Character;
use App\Models\Item;
use App\Services\TraderService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class TraderController extends Controller
{
    public function __construct(protected TraderService $traderService)
    {}

    public function index(TraderIndexRequest $request): Factory|View|Application|RedirectResponse
    {
        $data = $request->validated();
        $characterId = $data['character_id'];

        try {
            $traderData = $this->traderService->getTraderData($characterId);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('error.page')->withErrors('Персонаж не найден.');
        }

        return view('traders.index', $traderData);
    }

    public function buy(TraderBuyRequest $request, Item $item): RedirectResponse
    {
        $data = $request->validated();
        $character = Character::find($data['character_id']);

        try {
            $this->traderService->buyItem($character, $item);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('trader')->withErrors($e->getMessage());
        }


        return redirect()->route('trader');
    }

    public function sell(TraderSellRequest $request, Item $item): RedirectResponse
    {
        $data = $request->validated();
        $character = Character::find($data['character_id']);

        try {
            $this->traderService->sellItem($character, $item);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('trader')->withErrors($e->getMessage());
        }

        return redirect()->route('trader');
    }
}
