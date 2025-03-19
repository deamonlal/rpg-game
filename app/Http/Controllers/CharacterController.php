<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterStoreRequest;
use App\Models\Character;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CharacterController extends Controller
{
    public function index(): Application|Factory|View
    {
        $characters = Character::all();
        return view('characters.index', compact('characters'));
    }

    public function create(): Application|Factory|View
    {
        return view('characters.create');
    }

    public function store(CharacterStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Character::create($data);

        return redirect()->route('characters.index');
    }

    public function show(Character $character): Application|Factory|View
    {
        return view('characters.create', compact('character'));
    }

    public function edit(Character $character): Application|Factory|View
    {
        return view('characters.edit', compact('character'));
    }

    public function update(CharacterStoreRequest $request, Character $character): RedirectResponse
    {
        $data = $request->validated();
        $character->update($data);
        $character->save();
        return redirect()->route('characters.index');
    }

    public function destroy(Character $character): RedirectResponse
    {
        $character->delete();
        return redirect()->route('characters.index');
    }
}
