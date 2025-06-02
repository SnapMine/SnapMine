<?php

namespace Nirbose\PhpMcServ;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\DoubleTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;

class Registry
{
    public const TRIM_MATERIAL = [
        'asset_name' => StringTag::class,
        'ingredient' => StringTag::class,
        'item_model_index' => FloatTag::class,
        'description' => [
            'color' => StringTag::class,
            'translate' => StringTag::class,
        ],
    ];

    public const TRIM_PATTERN = [
        'asset_id' => StringTag::class,
        'template_item' => StringTag::class,
        'description' => [
            'color' => StringTag::class,
            'translate' => StringTag::class,
        ],
        'decal' => ByteTag::class,
    ];

    public const BANNER_PATTERN = [
        'asset_id' => StringTag::class,
        'translation_key' => StringTag::class,
    ];

    public const WORLDGEN_BIOME = [
        "carvers" => [ListTag::class, StringTag::class],
        'downfall' => FloatTag::class,
        'has_precipitation' => ByteTag::class,
        'temperature' => FloatTag::class,
        'temperature_modifier' => StringTag::class,
        'effects' => [
            'fog_color' => IntTag::class,
            'mood_sound' => [
                'sound' => StringTag::class,
                'tick_delay' => IntTag::class,
                'block_search_extent' => IntTag::class,
                'offset' => DoubleTag::class,
            ],
            'music' => [ListTag::class, [
                'data' => [
                    'max_delay' => IntTag::class,
                    'min_delay' => IntTag::class,
                    'replace_current_music' => ByteTag::class,
                    'sound' => StringTag::class,
                ],
                'weight' => IntTag::class,
            ]],
            'music_volume' => FloatTag::class,
            'sky_color' => IntTag::class,
            'water_color' => IntTag::class,
            'water_fog_color' => IntTag::class,
            'features' => [ListTag::class, [ListTag::class, StringTag::class]],
            'has_precipitation' => ByteTag::class,
            'spawners' => [
                'ambient' => [ListTag::class, [
                    'type' => StringTag::class,
                    'weight' => IntTag::class,
                    'min_count' => IntTag::class,
                    'max_count' => IntTag::class,
                ]],
                'axelotls' => [ListTag::class, [
                    'type' => StringTag::class,
                    'weight' => IntTag::class,
                    'min_count' => IntTag::class,
                    'max_count' => IntTag::class,
                ]],
                'creature' => [ListTag::class, [
                    'type' => StringTag::class,
                    'weight' => IntTag::class,
                    'min_count' => IntTag::class,
                    'max_count' => IntTag::class,
                ]],
                'misc' => [ListTag::class, [
                    'type' => StringTag::class,
                    'weight' => IntTag::class,
                    'min_count' => IntTag::class,
                    'max_count' => IntTag::class,
                ]],
                'monster' => [ListTag::class, [
                    'type' => StringTag::class,
                    'weight' => IntTag::class,
                    'min_count' => IntTag::class,
                    'max_count' => IntTag::class,
                ]],
                'underground_water_creature' => [ListTag::class, [
                    'type' => StringTag::class,
                    'weight' => IntTag::class,
                    'min_count' => IntTag::class,
                    'max_count' => IntTag::class,
                ]],
            ],
            'temperature' => FloatTag::class,
        ]
    ];

    public const CHAT_TYPE = [
        'chat' => [
            'translation_key' => StringTag::class,
            'parameters' => [ListTag::class, StringTag::class],
        ],
        'narration' => [
            'translation_key' => StringTag::class,
            'parameters' => [ListTag::class, StringTag::class],
        ],
    ];

    public const DAMAGE_TYPE = [
        'effects' => StringTag::class,
        'message_id' => StringTag::class,
        'scaling' => StringTag::class,
        'exhaustion' => FloatTag::class,
    ];

    public const DIMENSION_TYPE = [
        'has_skylight' => ByteTag::class,
        'has_ceiling' => ByteTag::class,
        'ultrawarm' => ByteTag::class,
        'natural' => ByteTag::class,
        'coordinate_scale' => DoubleTag::class,
        'bed_works' => ByteTag::class,
        'respawn_anchor_works' => ByteTag::class,
        'min_y' => IntTag::class,
        'height' => IntTag::class,
        'logical_height' => IntTag::class,
        'infiniburn' => StringTag::class,
        'effects' => StringTag::class,
        'ambient_light' => FloatTag::class,
        'piglin_safe' => ByteTag::class,
        'has_raids' => ByteTag::class,
        'monster_spawn_light_level' => [
            'max_inclusive' => IntTag::class,
            'min_inclusive' => IntTag::class,
            'type' => StringTag::class,
        ],
        'monster_spawn_block_light_limit' => IntTag::class,
    ];

    public const WOLF_VARIANT = [
        'assets' => [
            'angry' => StringTag::class,
            'tame' => StringTag::class,
            'wild' => StringTag::class,
        ],
        'spawn_conditions' => [ListTag::class, [
            'condition' => [
                'type' => StringTag::class,
                'biomes' => StringTag::class,
            ], 
            'priority' => IntTag::class,
        ]],
    ];

    public const PAINTING_VARIANT = [
        'asset_id' => StringTag::class,
        'height' => IntTag::class,
        'width' => IntTag::class,
        'title' => [
            'translate' => StringTag::class,
            'color' => StringTag::class,
        ],
        'author' => [
            'translate' => StringTag::class,
            'color' => StringTag::class,
        ],
    ];

    public const WOLF_SOUND_VARIANT = [
        'ambient_sound' => StringTag::class,
        'death_sound' => StringTag::class,
        'growl_sound' => StringTag::class,
        'hurt_sound' => StringTag::class,
        'pant_sound' => StringTag::class,
        'whine_sound' => StringTag::class,
    ];

    public const ANIMAL_VARIANT = [
        'asset_id' => StringTag::class,
        'model' => StringTag::class,
        'spawn_conditions' => [ListTag::class, [
            'condition' => [
                'type' => StringTag::class,
                'biomes' => StringTag::class,
            ], 
            'priority' => IntTag::class,
        ]],
    ];

    public static function getRegistry(string $id): array
    {
        return match ($id) {
            'minecraft:trim_material' => self::TRIM_MATERIAL,
            'minecraft:trim_pattern' => self::TRIM_PATTERN,
            'minecraft:banner_pattern' => self::BANNER_PATTERN,
            'minecraft:worldgen/biome' => self::WORLDGEN_BIOME,
            'minecraft:chat_type' => self::CHAT_TYPE,
            'minecraft:damage_type' => self::DAMAGE_TYPE,
            'minecraft:dimension_type' => self::DIMENSION_TYPE,
            'minecraft:wolf_variant' => self::WOLF_VARIANT,
            'minecraft:painting_variant' => self::PAINTING_VARIANT,
            'minecraft:wolf_sound_variant' => self::WOLF_SOUND_VARIANT,
            'minecraft:cow_variant',
            'minecraft:chicken_variant',
            'minecraft:cat_variant',
            'minecraft:pig_variant',
            'minecraft:frog_variant' => self::ANIMAL_VARIANT,
        };
    }
}