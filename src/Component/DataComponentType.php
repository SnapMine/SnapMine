<?php

namespace Nirbose\PhpMcServ\Component;

use Nirbose\PhpMcServ\Component\Item\BlockPredicates;
use Nirbose\PhpMcServ\Component\Item\CustomModelData;
use Nirbose\PhpMcServ\Component\Item\DyeItemColor;
use Nirbose\PhpMcServ\Component\Item\FoodProperties;
use Nirbose\PhpMcServ\Component\Item\ItemLore;
use Nirbose\PhpMcServ\Component\Item\TooltipDisplay;
use Nirbose\PhpMcServ\Entity\Variant\AxolotlVariant;
use Nirbose\PhpMcServ\Entity\Variant\FoxVariant;
use Nirbose\PhpMcServ\Entity\Variant\HorseVariant;
use Nirbose\PhpMcServ\Entity\Variant\LlamaVariant;
use Nirbose\PhpMcServ\Entity\Variant\MooshroomVariant;
use Nirbose\PhpMcServ\Entity\Variant\RabbitVariant;
use Nirbose\PhpMcServ\Entity\Variant\SalmonVariant;
use Nirbose\PhpMcServ\Entity\Variant\TropicalFishVariant;
use Nirbose\PhpMcServ\Inventory\ItemRarity;
use Nirbose\PhpMcServ\Utils\DyeColor;

enum DataComponentType: string
{
    /**
     * Customizable data that doesn't fit any specific component.
     */
    const CUSTOM_DATA = "";
    const MAX_STACK_SIZE = "";

    /**
     * The maximum damage the item can take before breaking.
     */
    const MAX_DAMAGE = "";

    /**
     * The current damage of the item.
     */
    const DAMAGE = "";

    const UNBREAKABLE = "";

    /**
     * Item's custom name.
     * Normally shown in italic, and changeable at an anvil.
     */
    const CUSTOM_NAME = "";

    /**
     * Override for the item's default name.
     * Shown when the item has no custom name.
     */
    const ITEM_NAME = "";
    const ITEM_MODEL = "";
    const LORE = ItemLore::class;
    const RARITY = ItemRarity::class;
    const ENCHANTMENTS = "";
    const CAN_PLACE_ON = BlockPredicates::class;
    const CAN_BREAK = BlockPredicates::class;
    const ATTRIBUTE_MODIFIERS = "";
    const CUSTOM_MODEL_DATA = CustomModelData::class;
    const TOOLTIP_DISPLAY = TooltipDisplay::class;
    const REPAIR_COST = "";

    /**
     * Marks the item as non-interactive on the creative inventory (the first 5 rows of items).
     * This is used internally by the client on the paper icon in the saved hot-bars tab.
     */
    const CREATIVE_SLOT_LOCK = ""; // Empty value (no fields)
    const ENCHANTMENT_GLINT_OVERRIDE = "";
    const INTANGIBLE_PROJECTILE = "";
    const FOOD = FoodProperties::class;
    const CONSUMABLE = "";
    const USE_REMAINDER = "";
    const USE_COOLDOWN = "";
    const DAMAGE_RESISTANT = "";
    const TOOL = "";
    const WEAPON = "";
    const ENCHANTABLE = "";
    const EQUIPPABLE = "";
    const REPAIRABLE = "";

    /**
     * Makes the item function like elytra.
     */
    const GLIDER = ""; // Empty value (no fields)
    const TOOLTIP_STYLE = "";
    const DEATH_PROTECTION = "";
    const BLOCKS_ATTACKS = "";
    const STORED_ENCHANTMENTS = "";

    /**
     * Color of dyed leather armor.
     */
    const DYED_COLOR = DyeItemColor::class;

    /**
     * Color of the markings on the map item model.
     */
    const MAP_COLOR = DyeItemColor::class;
    const MAP_ID = "";
    const MAP_DECORATIONS = "";
    const MAP_POST_PRECESSING = "";
    const CHARGED_PROJECTILES = "";
    const BUNDLE_CONTENTS = "";
    const POTION_CONTENTS = "";
    const POTION_DURATION_SCALE = "";
    const SUSPICIOUS_STEW_EFFECTS = "";
    const WRITABLE_BOOK_CONTENT = "";
    const WRITTEN_BOOK_CONTENT = "";
    const TRIM = "";
    const DEBUG_STICK_STATE = "";
    const ENTITY_DATA = "";
    const BUCKET_ENTITY_DATA = "";
    const BLOCK_ENTITY_DATA = "";
    const INSTRUMENT = "";
    const PROVIDES_TRIM_MATERIAL = "";
    const OMINOUS_BOTTLE_AMPLIFIER = "";
    const JUCKBOX_PLAYABLE = "";
    const PROVIDES_BANNER_PATTERNS = "";
    const RECIPES = "";
    const LODESTONE_TRACKER = "";
    const FIREWORK_EXPLOSION = "";
    const FIREWORKS = "";
    const PROFILE = "";
    const NOTE_BLOCK_SOUND = "";
    const BANNER_PATTERNS = "";

    /**
     * Base color of the banner applied to a shield.
     */
    const BASE_COLOR = DyeColor::class;
    const POT_DECORATIONS = "";
    const CONTAINER = "";
    const BLOCK_STATE = "";
    const BEES = "";
    const LOCK = "";
    const CONTAINER_LOOT = "";
    const BREAK_SOUND = "";
    const VILLAGER_VARIANT = "";
    const WOLF_VARIANT = "";
    const WOLF_SOUND_VARIANT = "";
    const WOLF_COLLAR = DyeColor::class;
    const FOX_VARIANT = FoxVariant::class;
    const SALMON_SIZE = SalmonVariant::class;
    const PARROT_VARIANT = "";
    const TROPICAL_FISH_PATTERN = TropicalFishVariant::class;
    const TROPICAL_FISH_BASE_COLOR = DyeColor::class;
    const TROPICAL_FISH_PATTERN_COLOR = DyeColor::class;
    const MOOSHROOM_VARIANT = MooshroomVariant::class;
    const RABBIT_VARIANT = RabbitVariant::class;
    const PIG_VARIANT = "";
    const COW_VARIANT = "";
    const CHICKEN_VARIANT = "";
    const FOG_VARIANT = "";
    const HORSE_VARIANT = HorseVariant::class;
    const PAINTING_VARIANT = "";
    const LLAMA_VARIANT = LlamaVariant::class;
    const AXOLOTL_VARIANT = AxolotlVariant::class;
    const CAT_VARIANT = "";
    const CAT_COLLAR = DyeColor::class;
    const SHEEP_COLOR = DyeColor::class;
    const SHULKER_COLOR = DyeColor::class;
}
