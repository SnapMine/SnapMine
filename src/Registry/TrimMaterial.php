<?php

declare(strict_types=1);

namespace SnapMine\Registry;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;
use SnapMine\Component\TextComponent;

/**
 * @method static TrimMaterial AMETHYST()
 * @method static TrimMaterial COPPER()
 * @method static TrimMaterial DIAMOND()
 * @method static TrimMaterial EMERALD()
 * @method static TrimMaterial GOLD()
 * @method static TrimMaterial IRON()
 * @method static TrimMaterial LAPIS()
 * @method static TrimMaterial NETHERITE()
 * @method static TrimMaterial QUARTZ()
 * @method static TrimMaterial REDSTONE()
 * @method static TrimMaterial RESIN()
 */
final class TrimMaterial extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly string $assetName,
        private readonly TextComponent $description,
        private readonly ?array $overrideArmorAssets = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('asset_name', Codecs::string(), fn (self $m) => $m->assetName),
            Field::required('description', TextComponent::codec(), fn (self $m) => $m->description),
            Field::optional('override_armor_assets', Codecs::mapOf(Codecs::string()), fn (self $m) => $m->overrideArmorAssets),
        );
    }

    public function getAssetName(): string
    {
        return $this->assetName;
    }

    public function getDescription(): TextComponent
    {
        return $this->description;
    }

    /**
     * @return array<string, string>|null
     */
    public function getOverrideArmorAssets(): ?array
    {
        return $this->overrideArmorAssets;
    }
}
