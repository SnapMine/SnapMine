<?php

declare(strict_types=1);

namespace Tests\Unit\Codec\Support;

use SnapMine\Codec\Codec;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * Test fixture: an example record mixing all field kinds.
 */
final class Player
{
    /** @param list<string> $inventory */
    public function __construct(
        public readonly string $name,
        public readonly ?string $guild,
        public readonly float $health,
        public readonly bool $vip,
        public readonly array $inventory,
    ) {
    }

    public static function codec(): RecordCodec
    {
        return RecordCodec::of(
            self::class,
            Field::required('name', Codecs::string(), fn (self $p) => $p->name),
            Field::optional('guild', Codecs::string(), fn (self $p) => $p->guild),
            Field::withDefault('health', Codecs::float(), 20.0, fn (self $p) => $p->health),
            Field::required('vip', Codecs::bool(), fn (self $p) => $p->vip),
            Field::required('inventory', Codecs::listOf(Codecs::string()), fn (self $p) => $p->inventory),
        );
    }
}