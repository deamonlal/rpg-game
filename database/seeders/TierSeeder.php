<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = "database/data/tiers.json";
        $json = File::get($filePath);
        $items = json_decode($json, true);

        $formattedItems = array_map(fn($items) => [
            "tier" => $items["tier"],
            "description" => $items["description"],
        ], $items);

        DB::table('tiers')->insert($formattedItems);
    }
}
