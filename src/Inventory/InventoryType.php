<?php

namespace SnapMine\Inventory;

enum InventoryType: int
{
    case PLAYER = -1;
    case GENERIC_9X1 = 0;
    case GENERIC_9X2 = 1;
    case GENERIC_9X3 = 2;
    case GENERIC_9X4 = 3;
    case GENERIC_9X5 = 4;
    case GENERIC_9X6 = 5;
    case GENERIC_3X3 = 6;
    case CRAFTER_3X3 = 7;
    case ANVIL = 8;
    case BEACON = 9;
    case BLAST_FURNACE = 10;
    case BREWING_STAND = 11;
    case CRAFTING = 12;
    case ENCHANTING = 13;
    case FURNACE = 14;
    case GRINDSTONE = 15;
    case HOPPER = 16;
    case LECTERN = 17;
    case LOOM = 18;
    case MERCHANT = 19;
    case SHULKER_BOX = 20;
    case SMITHING = 21;
    case SMOKER = 22;
    case CARTOGRAPHY_TABLE = 23;
    case STONECUTTER = 24;

    public function getSize(): int
    {
        return match ($this) {
            self::GENERIC_9X1, self::CRAFTER_3X3, self::GENERIC_3X3 => 9,
            self::GENERIC_9X2 => 18,
            self::GENERIC_9X3, self::SHULKER_BOX => 27,
            self::GENERIC_9X4 => 36,
            self::GENERIC_9X5 => 45,
            self::GENERIC_9X6 => 54,
            self::ANVIL, self::CARTOGRAPHY_TABLE, self::SMOKER, self::MERCHANT, self::GRINDSTONE, self::FURNACE, self::BLAST_FURNACE => 3,
            self::BEACON, self::LECTERN => 1,
            self::BREWING_STAND, self::HOPPER => 5,
            self::CRAFTING => 10,
            self::ENCHANTING, self::STONECUTTER => 2,
            self::LOOM, self::SMITHING => 4,
            self::PLAYER => 46,
        };
    }
}
