<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Item;
use Exception;

class InventoryService
{
    /**
     * Получает инвентарь персонажа по ID.
     *
     * @param int $characterId
     * @return array
     * @throws Exception
     */
    public function getInventoryItems(int $characterId): array
    {
        $character = Character::find($characterId);

        if (!$character) {
            // Обработка случая, когда персонаж не найден (например, редирект с ошибкой)
            throw new Exception('Character not found.');
        }

        return json_decode($character->inventory, true) ?? [];
    }

    /**
     * Получает список предметов с их описанием и дополнительной информацией.
     *
     * @param array $itemNames
     * @return array
     */
    public function getItemsWithDescription(array $itemNames): array
    {
        return Item::whereIn('name', $itemNames)
            ->with('tier')
            ->get(['name', 'description', 'type', 'tier_id'])
            ->toArray();
    }

    /**
     * Преобразует предметы с их типами и количеством.
     *
     * @param array $itemsWithDescription
     * @param array $inventoryItems
     * @return array
     */
    public function mapItemsWithDescription(array $itemsWithDescription, array $inventoryItems): array
    {
        $typeMap = $this->getTypeMap();

        foreach ($itemsWithDescription as &$item) {
            // Используем тип из маппинга, если он есть
            if (isset($typeMap[$item['type']])) {
                $item['type'] = $typeMap[$item['type']];
            }

            // Добавляем количество предмета из инвентаря, если оно есть
            if (isset($inventoryItems[$item['name']])) {
                $item['quantity'] = $inventoryItems[$item['name']];
            }
        }

        return $itemsWithDescription;
    }

    /**
     * Маппинг типов предметов.
     *
     * @return array
     */
    private function getTypeMap(): array
    {
        return [
            'armors' => 'Броня',
            'weapons' => 'Оружие',
            'alchemy' => 'Алхимия',
            'items' => 'Предмет',
            // Добавляйте новые типы предметов здесь
        ];
    }
}
