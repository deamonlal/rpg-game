<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterStoreRequest;
use App\Models\Character;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function update(CharacterStoreRequest $request, Character $character) {
        $data = $request->validated();
        $character->update($data);
        $character->save();
        return json_encode(['status' => 'success']);
    }

    public function destroy(Character $character) {
        $character->delete();
        return redirect()->route('characters.index');
    }
}
