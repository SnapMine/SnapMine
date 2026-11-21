<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * A spawn cost of a biome (`spawn_costs.<entity>`).
 */
final class SpawnCost implements CodecProvider
{
    public function __construct(
        private readonly float $charge,
        private readonly float $energyBudget,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('charge', Codecs::float(), fn (self $c) => $c->charge),
            Field::required('energy_budget', Codecs::float(), fn (self $c) => $c->energyBudget),
        );
    }

    public function getCharge(): float
    {
        return $this->charge;
    }

    public function getEnergyBudget(): float
    {
        return $this->energyBudget;
    }
}
