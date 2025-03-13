<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $character = Inventory::find($data['character_id']);

        return view('game', compact('character'));
    }
}
