<?php

namespace App\Services;

use App\Models\Armor;
use App\Models\Item;
use App\Models\Tier;
use App\Models\Weapon;
use Illuminate\Database\Eloquent\Collection;

class ItemService
{
    /**
     * Получение всех предметов с их связями.
     *
     * @return Collection
     */
    public function getAllItems(): Collection
    {
        return Item::with(['weapon', 'armor', 'tier'])->get();
    }

    /**
     * Создание предмета и привязка его к уровню.
     *
     * @param array $validated
     * @return Item
     */
    public function createItem(array $validated): Item
    {
        $tier = Tier::firstOrCreate(['tier' => $validated['tier']]);

        return Item::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'tier_id' => $tier->id,
        ]);
    }

    /**
     * Создание специфической для типа предмета сущности (оружие или броня).
     *
     * @param Item $item
     * @param array $validated
     * @return void
     */
    public function createItemTypeSpecific(Item $item, array $validated): void
    {
        switch ($validated['type']) {
            case 'weapon':
                $this->createWeapon($item, $validated['damage']);
                break;
            case 'armor':
                $this->createArmor($item, $validated['armor']);
                break;
        }
    }

    /**
     * Создание оружия.
     *
     * @param Item $item
     * @param int $damage
     * @return void
     */
    public function createWeapon(Item $item, int $damage): void
    {
        Weapon::create([
            'item_id' => $item->id,
            'damage' => $damage
        ]);
    }

    /**
     * Создание брони.
     *
     * @param Item $item
     * @param int $armor
     * @return void
     */
    public function createArmor(Item $item, int $armor): void
    {
        Armor::create([
            'item_id' => $item->id,
            'armor' => $armor
        ]);
    }
}
