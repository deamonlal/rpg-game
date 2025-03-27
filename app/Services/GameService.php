<?php

namespace App\Services;

use App\Models\Character;

class GameService
{
    public function getArmor(Character $character)
    {
        $armor = 0;
        foreach ($character->equipment as $equip) {
            if (isset($equip->item->armor)) {
                $armor += $equip->item->armor->armor;
            }
        }

        return $armor;
    }

    public  function getDamage(Character $character)
    {
        $damage = 0;
        foreach ($character->equipment as $equip) {
            if (isset($equip->item->weapon)) {
                $damage += $equip->item->weapon->damage;
            }
        }

        return $damage + $character->level;
    }
}
