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

/**
 * Enumeration of all data component types for items and entities.
 * 
 * Data components are used in Minecraft's item system to store various
 * properties and metadata about items and entities. Each component type
 * represents a specific kind of data that can be attached to items,
 * such as damage, enchantments, lore, custom names, and entity variants.
 * 
 * This enum provides type-safe access to all available component types
 * and includes mapping to their corresponding handler classes for
 * proper serialization and data management.
 * 
 * @since   0.0.1
 */
enum DataComponentType
{
    /** Customizable data that doesn't fit any specific component */
    case CUSTOM_DATA;
    
    /** Maximum number of items that can be stacked together */
    case MAX_STACK_SIZE;

    /** The maximum damage the item can take before breaking */
    case MAX_DAMAGE;

    /** The current damage of the item */
    case DAMAGE;

    /** Whether the item is unbreakable and won't take damage */
    case UNBREAKABLE;

    /** Item's custom name. Normally shown in italic, and changeable at an anvil */
    case CUSTOM_NAME;

    /** Override for the item's default name. Shown when the item has no custom name */
    case ITEM_NAME;
    
    /** Custom item model identifier for resource packs */
    case ITEM_MODEL;
    
    /** Item lore text (additional flavor text lines displayed in tooltip) */
    case LORE;
    
    /** Item rarity (affects name color: common, uncommon, rare, epic) */
    case RARITY;
    
    /** Enchantments applied to the item with their levels */
    case ENCHANTMENTS;
    
    /** Blocks this item can be placed on in adventure mode */
    case CAN_PLACE_ON;
    
    /** Blocks this item can break in adventure mode */
    case CAN_BREAK;
    
    /** Attribute modifiers applied when item is held or equipped */
    case ATTRIBUTE_MODIFIERS;
    
    /** Custom model data for advanced resource pack models */
    case CUSTOM_MODEL_DATA;
    
    /** Tooltip display behavior and styling options */
    case TOOLTIP_DISPLAY;
    
    /** Repair cost for anvil operations (increases with each repair) */
    case REPAIR_COST;

    /** Marks the item as non-interactive on the creative inventory */
    case CREATIVE_SLOT_LOCK;
    
    /** Override for enchantment glint visibility */
    case ENCHANTMENT_GLINT_OVERRIDE;
    
    /** Whether projectiles pass through this item without collision */
    case INTANGIBLE_PROJECTILE;
    
    /** Food properties (nutrition, saturation, effects when consumed) */
    case FOOD;
    
    /** Whether the item can be consumed and consumption behavior */
    case CONSUMABLE;
    
    /** Item returned after using this item (like bucket after milk) */
    case USE_REMAINDER;
    
    /** Cooldown period after using this item */
    case USE_COOLDOWN;
    
    /** Damage resistance properties for armor */
    case DAMAGE_RESISTANT;
    
    /** Tool properties (damage, speed, mining rules) */
    case TOOL;
    
    /** Weapon properties for combat items */
    case WEAPON;
    
    /** What enchantments can be applied to this item */
    case ENCHANTABLE;
    
    /** Equipment slot and behavior for wearable items */
    case EQUIPPABLE;
    
    /** What items can be used to repair this item */
    case REPAIRABLE;

    /** Makes the item function like elytra for gliding */
    case GLIDER;
    
    /** Custom tooltip styling and formatting */
    case TOOLTIP_STYLE;
    
    /** Protection from death effects (like totem of undying) */
    case DEATH_PROTECTION;
    
    /** Whether the item can block attacks (shields) */
    case BLOCKS_ATTACKS;
    
    /** Stored enchantments (for enchanted books and similar items) */
    case STORED_ENCHANTMENTS;

    /** Color of dyed leather armor and similar items */
    case DYED_COLOR;

    /** Color of the markings on the map item model */
    case MAP_COLOR;
    
    /** Unique identifier for map data */
    case MAP_ID;
    
    /** Map decorations and markers (banners, icons, etc.) */
    case MAP_DECORATIONS;
    
    /** Map post-processing effects and filters */
    case MAP_POST_PRECESSING;
    
    /** Charged projectiles stored in crossbows */
    case CHARGED_PROJECTILES;
    
    /** Contents of bundle items */
    case BUNDLE_CONTENTS;
    
    /** Potion effects and properties */
    case POTION_CONTENTS;
    
    /** Duration scaling for potion effects */
    case POTION_DURATION_SCALE;
    
    /** Effects applied when consuming suspicious stew */
    case SUSPICIOUS_STEW_EFFECTS;
    
    /** Content of writable books (editable text) */
    case WRITABLE_BOOK_CONTENT;
    
    /** Content and metadata of written books */
    case WRITTEN_BOOK_CONTENT;
    
    /** Armor trim patterns and materials */
    case TRIM;
    
    /** Debug stick state for block property modification */
    case DEBUG_STICK_STATE;
    
    /** Entity data stored within items */
    case ENTITY_DATA;
    
    /** Entity data for bucket-captured entities */
    case BUCKET_ENTITY_DATA;
    
    /** Block entity data (like chest contents, signs, etc.) */
    case BLOCK_ENTITY_DATA;
    
    /** Instrument type for goat horns and music items */
    case INSTRUMENT;
    
    /** Whether item provides trim material when used */
    case PROVIDES_TRIM_MATERIAL;
    
    /** Ominous bottle amplifier level */
    case OMINOUS_BOTTLE_AMPLIFIER;
    
    /** Whether the item can be played in jukeboxes */
    case JUCKBOX_PLAYABLE;
    
    /** Banner patterns provided by this item */
    case PROVIDES_BANNER_PATTERNS;
    
    /** Available recipes unlocked by this item */
    case RECIPES;
    
    /** Lodestone tracker data for compass targeting */
    case LODESTONE_TRACKER;
    
    /** Firework explosion properties and effects */
    case FIREWORK_EXPLOSION;
    
    /** Fireworks rocket data and flight duration */
    case FIREWORKS;
    
    /** Player profile data for player heads */
    case PROFILE;
    
    /** Note block sound when placed */
    case NOTE_BLOCK_SOUND;
    
    /** Banner patterns and their colors */
    case BANNER_PATTERNS;

    /** Base color of the banner applied to a shield */
    case BASE_COLOR;
    
    /** Decorative pot patterns and designs */
    case POT_DECORATIONS;
    
    /** Container contents and inventory data */
    case CONTAINER;
    
    /** Block state properties and values */
    case BLOCK_STATE;
    
    /** Bee entity data for hives and nests */
    case BEES;
    
    /** Container lock key requirement */
    case LOCK;
    
    /** Container loot table for random generation */
    case CONTAINER_LOOT;
    
    /** Custom block break sound */
    case BREAK_SOUND;
    
    /** Villager profession and trade data */
    case VILLAGER_VARIANT;
    
    /** Wolf breed and appearance variant */
    case WOLF_VARIANT;
    
    /** Wolf sound variant for different breeds */
    case WOLF_SOUND_VARIANT;
    
    /** Wolf collar color */
    case WOLF_COLLAR;
    
    /** Fox breed and color variant */
    case FOX_VARIANT;
    
    /** Salmon size variant */
    case SALMON_SIZE;
    
    /** Parrot color and breed variant */
    case PARROT_VARIANT;
    
    /** Tropical fish pattern type */
    case TROPICAL_FISH_PATTERN;
    
    /** Tropical fish base body color */
    case TROPICAL_FISH_BASE_COLOR;
    
    /** Tropical fish pattern color */
    case TROPICAL_FISH_PATTERN_COLOR;
    
    /** Mooshroom breed variant (red or brown) */
    case MOOSHROOM_VARIANT;
    
    /** Rabbit breed and color variant */
    case RABBIT_VARIANT;
    
    /** Pig breed variant */
    case PIG_VARIANT;
    
    /** Cow breed variant */
    case COW_VARIANT;
    
    /** Chicken breed variant */
    case CHICKEN_VARIANT;
    
    /** Fog color variant for specific biomes */
    case FOG_VARIANT;
    
    /** Horse breed, color, and marking variant */
    case HORSE_VARIANT;
    
    /** Painting artwork variant */
    case PAINTING_VARIANT;
    
    /** Llama color and pattern variant */
    case LLAMA_VARIANT;
    
    /** Axolotl color variant */
    case AXOLOTL_VARIANT;
    
    /** Cat breed and appearance variant */
    case CAT_VARIANT;
    
    /** Cat collar color */
    case CAT_COLLAR;
    
    /** Sheep wool color */
    case SHEEP_COLOR;
    
    /** Shulker box color */
    case SHULKER_COLOR;

    /**
     * Get the handler class for this component type.
     * 
     * Returns the fully qualified class name that handles serialization
     * and data management for this component type. Returns null if no
     * specific handler class is defined for the component.
     * 
     * @return string|null The handler class name, or null if no handler exists
     * 
     * @example
     * ```php
     * $handlerClass = DataComponentType::LORE->handlerClass();
     * // Returns: ItemLore::class
     * 
     * $handlerClass = DataComponentType::CUSTOM_DATA->handlerClass();
     * // Returns: null (no specific handler)
     * 
     * $colorHandler = DataComponentType::DYED_COLOR->handlerClass();
     * // Returns: DyeColor::class
     * ```
     */
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
