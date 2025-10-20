<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;

/**
 * @method static TrimPattern BOLT()
 * @method static TrimPattern COAST()
 * @method static TrimPattern DUNE()
 * @method static TrimPattern EYE()
 * @method static TrimPattern FLOW()
 * @method static TrimPattern HOST()
 * @method static TrimPattern RAISER()
 * @method static TrimPattern RIB()
 * @method static TrimPattern SENTRY()
 * @method static TrimPattern SHAPER()
 * @method static TrimPattern SILENCE()
 * @method static TrimPattern SNOUT()
 * @method static TrimPattern SPIRE()
 * @method static TrimPattern TIDE()
 * @method static TrimPattern VEX()
 * @method static TrimPattern WARD()
 * @method static TrimPattern WAYFINDER()
 * @method static TrimPattern WILD()
 */
class TrimPattern extends RegistryData implements EncodableToNbt
{

    public function toNbt(): CompoundTag
    {
        $base = new CompoundTag();

        $base
            ->set('asset_id', (new StringTag())->setValue($this->data['asset_id']))
            ->set('decal', (new ByteTag())->setValue($this->data['decal']))
            ->set('description', (new CompoundTag())
                ->set('translate', (new StringTag())->setValue($this->data['description']['translate']))
            );

        return $base;
    }
}