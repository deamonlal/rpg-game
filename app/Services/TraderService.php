<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Item;
use Exception;

class TraderService
{
    const TRADER_MARKUP = 1.3;
    const TRADER_DISCOUNT = 0.75;

    /**
     * Получаем данные для страницы торговли: предметы торговца и предметы персонажа.
     *
     * @param int $characterId
     * @return array
     * @throws Exception
     */
    public function getTraderData(int $characterId): array
    {
        $character = Character::find($characterId);
        if (!$character) {
            throw new Exception("Character not found.");
        }

        $traderItems = Item::inRandomOrder()->limit(5)->get();
        $charItems = json_decode($character->inventory, true);
        $charItemKeys = array_keys($charItems ?? []);
        $characterItems = Item::whereIn('name', $charItemKeys)->get();

        return [
            'character' => $character,
            'traderItems' => $traderItems,
            'characterItems' => $characterItems,
        ];
    }

    /**
     * Покупка предмета у торговца
     *
     * @param Character $character
     * @param Item $item
     * @return bool
     * @throws Exception
     */
    public function buyItem(Character $character, Item $item): bool
    {
        $money = $character->gold;
        $inventory = json_decode($character->inventory, true);
        $cost = $item->price * self::TRADER_MARKUP;

        if ($money < $cost) {
            throw new Exception('Недостаточно средств для покупки.');
        }

        $money -= $cost;
        $this->updateInventory($inventory, $item->name, 1);

        $character->gold = $money;
        $character->inventory = json_encode($inventory);
        $character->save();

        return true; // Успешная покупка
    }

    /**
     * Продажа предмета игрока
     *
     * @param Character $character
     * @param Item $item
     * @return bool
     * @throws Exception
     */
    public function sellItem(Character $character, Item $item): bool
    {
        $money = $character->gold;
        $inventory = json_decode($character->inventory, true);
        $cost = $item->price * self::TRADER_DISCOUNT;

        if (!key_exists($item->name, $inventory)) {
            throw new Exception('Предмет отсутствует в инвентаре.');
        }

        $inventory[$item->name] -= 1;
        if ($inventory[$item->name] < 1) {
            unset($inventory[$item->name]);
        }

        $money += $cost;

        $character->gold = $money;
        $character->inventory = json_encode($inventory);
        $character->save();

        return true; // Успешная продажа
    }

    /**
     * Обновляем инвентарь игрока
     *
     * @param array $inventory
     * @param string $itemName
     * @param int $quantity
     * @return void
     */
    private function updateInventory(array &$inventory, string $itemName, int $quantity): void
    {
        if (isset($inventory[$itemName])) {
            $inventory[$itemName] += $quantity;
        } else {
            $inventory[$itemName] = $quantity;
        }
    }
}
