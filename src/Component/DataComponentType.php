<?php

namespace SnapMine\Component;

use SnapMine\Component\Item\BlockPredicates;
use SnapMine\Component\Item\CustomModelData;
use SnapMine\Component\Item\DyeItemColor;
use SnapMine\Component\Item\FoodProperties;
use SnapMine\Component\Item\ItemLore;
use SnapMine\Component\Item\TooltipDisplay;
use SnapMine\Entity\Variant\AxolotlVariant;
use SnapMine\Entity\Variant\FoxVariant;
use SnapMine\Entity\Variant\HorseVariant;
use SnapMine\Entity\Variant\LlamaVariant;
use SnapMine\Entity\Variant\MooshroomVariant;
use SnapMine\Entity\Variant\RabbitVariant;
use SnapMine\Entity\Variant\SalmonVariant;
use SnapMine\Entity\Variant\TropicalFishVariant;
use SnapMine\Inventory\ItemRarity;
use SnapMine\Utils\DyeColor;

enum DataComponentType
{
    /**
     * Customizable data that doesn't fit any specific component.
     */
    case CUSTOM_DATA;
    case MAX_STACK_SIZE;

    /**
     * The maximum damage the item can take before breaking.
     */
    case MAX_DAMAGE;

    /**
     * The current damage of the item.
     */
    case DAMAGE;

    case UNBREAKABLE;

    /**
     * Item's custom name.
     * Normally shown in italic, and changeable at an anvil.
     */
    case CUSTOM_NAME;

    /**
     * Override for the item's default name.
     * Shown when the item has no custom name.
     */
    case ITEM_NAME;
    case ITEM_MODEL;
    case LORE;
    case RARITY;
    case ENCHANTMENTS;
    case CAN_PLACE_ON;
    case CAN_BREAK;
    case ATTRIBUTE_MODIFIERS;
    case CUSTOM_MODEL_DATA;
    case TOOLTIP_DISPLAY;
    case REPAIR_COST;

    /**
     * Marks the item as non-interactive on the creative inventory (the first 5 rows of items).
     * This is used internally by the client on the paper icon in the saved hot-bars tab.
     */
    case CREATIVE_SLOT_LOCK; // Empty value (no fields)
    case ENCHANTMENT_GLINT_OVERRIDE;
    case INTANGIBLE_PROJECTILE;
    case FOOD;
    case CONSUMABLE;
    case USE_REMAINDER;
    case USE_COOLDOWN;
    case DAMAGE_RESISTANT;
    case TOOL;
    case WEAPON;
    case ENCHANTABLE;
    case EQUIPPABLE;
    case REPAIRABLE;

    /**
     * Makes the item function like elytra.
     */
    case GLIDER; // Empty value (no fields)
    case TOOLTIP_STYLE;
    case DEATH_PROTECTION;
    case BLOCKS_ATTACKS;
    case STORED_ENCHANTMENTS;

    /**
     * Color of dyed leather armor.
     */
    case DYED_COLOR;

    /**
     * Color of the markings on the map item model.
     */
    case MAP_COLOR;
    case MAP_ID;
    case MAP_DECORATIONS;
    case MAP_POST_PRECESSING;
    case CHARGED_PROJECTILES;
    case BUNDLE_CONTENTS;
    case POTION_CONTENTS;
    case POTION_DURATION_SCALE;
    case SUSPICIOUS_STEW_EFFECTS;
    case WRITABLE_BOOK_CONTENT;
    case WRITTEN_BOOK_CONTENT;
    case TRIM;
    case DEBUG_STICK_STATE;
    case ENTITY_DATA;
    case BUCKET_ENTITY_DATA;
    case BLOCK_ENTITY_DATA;
    case INSTRUMENT;
    case PROVIDES_TRIM_MATERIAL;
    case OMINOUS_BOTTLE_AMPLIFIER;
    case JUCKBOX_PLAYABLE;
    case PROVIDES_BANNER_PATTERNS;
    case RECIPES;
    case LODESTONE_TRACKER;
    case FIREWORK_EXPLOSION;
    case FIREWORKS;
    case PROFILE;
    case NOTE_BLOCK_SOUND;
    case BANNER_PATTERNS;

    /**
     * Base color of the banner applied to a shield.
     */
    case BASE_COLOR;
    case POT_DECORATIONS;
    case CONTAINER;
    case BLOCK_STATE;
    case BEES;
    case LOCK;
    case CONTAINER_LOOT;
    case BREAK_SOUND;
    case VILLAGER_VARIANT;
    case WOLF_VARIANT;
    case WOLF_SOUND_VARIANT;
    case WOLF_COLLAR;
    case FOX_VARIANT;
    case SALMON_SIZE;
    case PARROT_VARIANT;
    case TROPICAL_FISH_PATTERN;
    case TROPICAL_FISH_BASE_COLOR;
    case TROPICAL_FISH_PATTERN_COLOR;
    case MOOSHROOM_VARIANT;
    case RABBIT_VARIANT;
    case PIG_VARIANT;
    case COW_VARIANT;
    case CHICKEN_VARIANT;
    case FOG_VARIANT;
    case HORSE_VARIANT;
    case PAINTING_VARIANT;
    case LLAMA_VARIANT;
    case AXOLOTL_VARIANT;
    case CAT_VARIANT;
    case CAT_COLLAR;
    case SHEEP_COLOR;
    case SHULKER_COLOR;

    public function handlerClass(): ?string
    {
        return match ($this) {
            self::LORE => ItemLore::class,
            self::RARITY => ItemRarity::class,
            self::CAN_PLACE_ON, self::CAN_BREAK => BlockPredicates::class,
            self::CUSTOM_MODEL_DATA => CustomModelData::class,
            self::TOOLTIP_DISPLAY => TooltipDisplay::class,
            self::FOOD => FoodProperties::class,
            self::DYED_COLOR, self::MAP_COLOR, self::TROPICAL_FISH_BASE_COLOR, self::TROPICAL_FISH_PATTERN_COLOR,
            self::CAT_COLLAR, self::SHEEP_COLOR, self::SHULKER_COLOR, self::WOLF_COLLAR, self::BASE_COLOR
            => DyeColor::class,
            self::FOX_VARIANT => FoxVariant::class,
            self::SALMON_SIZE => SalmonVariant::class,
            self::TROPICAL_FISH_PATTERN => TropicalFishVariant::class,
            self::MOOSHROOM_VARIANT => MooshroomVariant::class,
            self::RABBIT_VARIANT => RabbitVariant::class,
            self::HORSE_VARIANT => HorseVariant::class,
            self::LLAMA_VARIANT => LlamaVariant::class,
            self::AXOLOTL_VARIANT => AxolotlVariant::class,
            default => null,
        };
    }
}
