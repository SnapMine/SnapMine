<?php

namespace SnapMine\Registry;

use SnapMine\Entity\Variant\CatVariant;
use SnapMine\Entity\Variant\ChickenVariant;
use SnapMine\Entity\Variant\CowVariant;
use SnapMine\Entity\Variant\FrogVariant;
use SnapMine\Entity\Variant\PaintingVariant;
use SnapMine\Entity\Variant\PigVariant;
use SnapMine\Entity\Variant\WolfSoundVariant;
use SnapMine\Entity\Variant\WolfVariant;
use SnapMine\Utils\NbtJson;
use SnapMine\World\Biome;
use SnapMine\World\DimensionType;

enum Registry: string
{
    case CAT_VARIANT = CatVariant::class;
    case CHAT_TYPE = ChatType::class;
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

            /** @var RegistryData $registryData */
            $registryData = $value->value;

            foreach (glob($pattern) as $entry) {
                $filename = basename($entry, ".json");
                $data = json_decode(file_get_contents($entry), true);

                $registryData::register($filename, 'minecraft:' . $filename, NbtJson::fromJson($data, $value->value));
            }
        }
    }
}