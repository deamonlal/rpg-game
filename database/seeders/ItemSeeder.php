<?php

namespace Database\Seeders;

use App\Models\Armor;
use App\Models\Item;
use App\Models\Tier;
use App\Models\Weapon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $filePath = "database/data/items.json";
        $json = File::get($filePath);
        $items = json_decode($json, true);

        foreach ($items as $data) {
            $tier = Tier::firstOrCreate(['tier' => $data['tier']]);

            if (Item::where('name', $data['name'])->exists()) {
                continue;
            }

            $item = Item::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'type' => $data['type'],
                'tier_id' => $tier->id,
                'price' => $data['price'],
            ]);

            if ($data['type'] === 'weapon') {
                Weapon::create([
                    'item_id' => $item->id,
                    'damage' => $data['damage'],
                    'slot' => $data['slot'],
                ]);
            } elseif ($data['type'] === 'armor') {
                Armor::create([
                    'item_id' => $item->id,
                    'armor' => $data['armor'],
                    'slot' => $data['slot'],
                ]);
            }
        }
    }
}
