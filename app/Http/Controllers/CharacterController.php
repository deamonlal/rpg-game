<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterStoreRequest;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index() {
        $characters = Character::all();
        return view('characters.index', compact('characters'));
    }

    public function create() {
        return view('characters.create');
    }

    public function store(CharacterStoreRequest $request) {
        $data = $request->validated();
        Character::create($data);

        return redirect()->route('characters.index');
    }

    public function show(Character $character) {
        return view('characters.create', compact('character'));
    }

    public function edit(Character $character) {
        return view('characters.edit', compact('character'));
    }

    public function update(CharacterStoreRequest$request, Character $character) {
        $data = $request->validated();
        $character->update($data);
    }

    public function destroy(Character $character) {
        $character->delete();
        return redirect()->route('characters.index');
    }
}
