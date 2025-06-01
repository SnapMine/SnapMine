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
        'has_precipitation' => ByteTag::class,
        'temperature' => FloatTag::class,
        'temperature_modifier' => StringTag::class,
        'downfall' => FloatTag::class,
        'effects' => [
            'fog_color' => IntTag::class,
            'water_color' => IntTag::class,
            'water_fog_color' => IntTag::class,
            'sky_color' => IntTag::class,
            'foliage_color' => IntTag::class,
            'grass_color' => IntTag::class,
            'grass_color_modifier' => StringTag::class,
            'particle' => [
                'options' => [
                    'type' => StringTag::class,
                ],
                'probability' => FloatTag::class,
            ],
            'ambient_sound' => StringTag::class,
            'mood_sound' => [
                'sound' => StringTag::class,
                'tick_delay' => IntTag::class,
                'block_search_extent' => IntTag::class,
                'offset' => DoubleTag::class,
            ],
            'additions_sound' => [
                'sound' => StringTag::class,
                'tick_chance' => DoubleTag::class,
            ],
            'music' => [
                'sound' => StringTag::class,
                'replace_current_music' => ByteTag::class,
                'max_delay' => IntTag::class,
                'min_delay' => IntTag::class,
            ],
        ]
    ];

    public const CHAT_TYPE = [
        'chat' => [
            'translation_key' => StringTag::class,
            'parameters' => ListTag::class,
        ],
        'narration' => [
            'translation_key' => StringTag::class,
            'parameters' => ListTag::class,
        ],
    ];

    public const DAMAGE_TYPE = [
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
        'wild_texture' => StringTag::class,
        'tame_texture' => StringTag::class,
        'angry_texture' => StringTag::class,
        'biomes' => StringTag::class, // List of StringTag
    ];

    public const PAINTING_VARIANT = [
        'asset_id' => StringTag::class,
        'height' => IntTag::class,
        'width' => IntTag::class,
        'title' => StringTag::class,
        'author' => StringTag::class,
    ];

    public static function getRegistry(string $name): array
    {
        $name = str_replace([
            'minecraft:',
            '/',
        ], [
            '',
            '_',
        ], $name);
        $name = strtoupper($name);
        $registry = constant("self::" . strtoupper($name));
        if (!is_array($registry)) {
            throw new \InvalidArgumentException("Registry '$name' does not exist or is not an array.");
        }
        return $registry;
    }
}