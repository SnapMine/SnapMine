<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Keyed;

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
class TrimMaterial extends RegistryData implements EncodableToNbt
{
    public function toNbt(): CompoundTag
    {
        $base = new CompoundTag();

        $base
            ->set('asset_name', (new StringTag())->setValue($this->data['asset_name']))
            ->set('description', (new CompoundTag())
                ->set('color', (new StringTag())->setValue($this->data['description']['color']))
                ->set('translate', (new StringTag())->setValue($this->data['description']['translate']))
            );

        return $base;
    }
}