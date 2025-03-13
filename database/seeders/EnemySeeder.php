<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EnemySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = "database/data/enemies.json";
        $json = File::get($filePath);
        $enemies = json_decode($json, true);
        array_walk_recursive($enemies, fn (&$value, $key) => $value = mb_strtolower($value));

        if (!empty($enemies)) {
            // Преобразуем массив в формат, подходящий для insert
            $formattedEnemies = array_map(fn($enemy) => [
                "name" => $enemy["name"],
                "level" => $enemy["level"],
                "damage" => $enemy["damage"],
                "exp_gain" => $enemy["exp_gain"],
                "gold_gain" => $enemy["gold_gain"],
                "health" => $enemy["health"],
                "items" => json_encode($enemy["items"]),
                "skills" => json_encode($enemy["skills"]),
                "tier" => $enemy["tier"],
                "created_at" => now(),
                "updated_at" => now(),
            ], $enemies);

            DB::table('enemies')->insert($formattedEnemies);
        }
    }
}
