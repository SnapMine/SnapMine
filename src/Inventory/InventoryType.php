<?php

namespace SnapMine\Inventory;

/**
 * Enumeration of all inventory types in Minecraft.
 * 
 * This enum defines the different types of inventories that can exist,
 * from player inventories to various container and interface inventories.
 * Each inventory type has an associated size that determines the number
 * of slots available in that inventory.
 * 
 * @package SnapMine\Inventory
 * @author  Nirbose
 * @since   1.0.0
 */
enum InventoryType: int
{
    /** Player inventory (includes main inventory, hotbar, armor, and offhand) */
    case PLAYER = -1;
    
    /** Generic container with 1 row (9 slots) */
    case GENERIC_9X1 = 0;
    
    /** Generic container with 2 rows (18 slots) */
    case GENERIC_9X2 = 1;
    
    /** Generic container with 3 rows (27 slots) */
    case GENERIC_9X3 = 2;
    
    /** Generic container with 4 rows (36 slots) */
    case GENERIC_9X4 = 3;
    
    /** Generic container with 5 rows (45 slots) */
    case GENERIC_9X5 = 4;
    
    /** Generic container with 6 rows (54 slots) */
    case GENERIC_9X6 = 5;
    
    /** Generic 3x3 container (9 slots) */
    case GENERIC_3X3 = 6;
    
    /** Crafter block inventory (3x3 grid, 9 slots) */
    case CRAFTER_3X3 = 7;
    
    /** Anvil interface (3 slots: 2 input + 1 output) */
    case ANVIL = 8;
    
    /** Beacon interface (1 slot for payment item) */
    case BEACON = 9;
    
    /** Blast furnace interface (3 slots: input + fuel + output) */
    case BLAST_FURNACE = 10;
    
    /** Brewing stand interface (5 slots: 3 bottles + 1 ingredient + 1 fuel) */
    case BREWING_STAND = 11;
    
    /** Crafting table interface (10 slots: 3x3 grid + 1 result) */
    case CRAFTING = 12;
    
    /** Enchanting table interface (2 slots: item + lapis) */
    case ENCHANTING = 13;
    
    /** Furnace interface (3 slots: input + fuel + output) */
    case FURNACE = 14;
    
    /** Grindstone interface (3 slots: 2 input + 1 output) */
    case GRINDSTONE = 15;
    
    /** Hopper inventory (5 slots) */
    case HOPPER = 16;
    
    /** Lectern interface (1 slot for book) */
    case LECTERN = 17;
    
    /** Loom interface (4 slots: banner + dye + pattern + result) */
    case LOOM = 18;
    
    /** Merchant/villager trading interface (3 slots: 2 input + 1 output) */
    case MERCHANT = 19;
    
    /** Shulker box inventory (27 slots, same as chest) */
    case SHULKER_BOX = 20;
    
    /** Smithing table interface (4 slots: template + base + addition + result) */
    case SMITHING = 21;
    
    /** Smoker interface (3 slots: input + fuel + output) */
    case SMOKER = 22;
    
    /** Cartography table interface (3 slots: map + paper + result) */
    case CARTOGRAPHY_TABLE = 23;
    
    /** Stonecutter interface (2 slots: input + output) */
    case STONECUTTER = 24;

    /**
     * Get the number of slots in this inventory type.
     * 
     * Returns the total number of inventory slots available for this
     * inventory type. This includes all input, output, and storage slots.
     * 
     * @return int The number of slots in this inventory type
     * 
     * @example
     * ```php
     * $chestSize = InventoryType::GENERIC_9X3->getSize(); // Returns 27
     * $playerSize = InventoryType::PLAYER->getSize(); // Returns 46
     * $anvilSize = InventoryType::ANVIL->getSize(); // Returns 3
     * ```
     */
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
