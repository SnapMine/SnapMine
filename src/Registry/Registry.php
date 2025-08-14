<?php

namespace Nirbose\PhpMcServ\Registry;

use Nirbose\PhpMcServ\Entity\Variant\CatVariant;
use Nirbose\PhpMcServ\Entity\Variant\ChickenVariant;
use Nirbose\PhpMcServ\Entity\Variant\CowVariant;
use Nirbose\PhpMcServ\Entity\Variant\FrogVariant;
use Nirbose\PhpMcServ\Entity\Variant\PaintingVariant;
use Nirbose\PhpMcServ\Entity\Variant\PigVariant;
use Nirbose\PhpMcServ\Entity\Variant\WolfSoundVariant;
use Nirbose\PhpMcServ\Entity\Variant\WolfVariant;
use Nirbose\PhpMcServ\World\Biome;
use Nirbose\PhpMcServ\World\DimensionType;

enum Registry: string
{
    case CAT_VARIANT = CatVariant::class;
    case CHICKEN_VARIANT = ChickenVariant::class;
    case COW_VARIANT = CowVariant::class;
    case FROG_VARIANT = FrogVariant::class;
    case PAINTING_VARIANT = PaintingVariant::class;
    case TRIM_MATERIAL = TrimMaterial::class;
    case TRIM_PATTERN = TrimPattern::class;
    case WOLF_VARIANT = WolfVariant::class;
    case WOLF_SOUND_VARIANT = WolfSoundVariant::class;
    case PIG_VARIANT = PigVariant::class;
    case DIMENSION_TYPE = DimensionType::class;
    case DAMAGE_TYPE = DamageType::class;
    case WORLDGEN__BIOME = Biome::class;

    public static function load(string $dirPath): void
    {
        foreach (self::cases() as $value) {
            if (str_contains($value->name, '__')) {
                $files = explode('__', $value->name);
                $path = implode('/', $files);

                $pattern = $dirPath . strtolower($path) . '/*.json';
            } else {
                $pattern =  $dirPath . strtolower($value->name) . '/*.json';
            }

            foreach (glob($pattern) as $entry) {
                $filename = basename($entry, ".json");
                $data = json_decode(file_get_contents($entry), true);

                $value->value::register($filename, 'minecraft:' . $filename, $data);
            }
        }
    }
}