<?php

declare(strict_types=1);

namespace Tests\Unit\Codec\Support;

use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * Test fixture: the `block_states` compound holding a block palette.
 */
final class BlockStates
{
    /** @param list<PaletteEntry> $palette */
    public function __construct(public readonly array $palette)
    {
    }

    public static function codec(): RecordCodec
    {
        return RecordCodec::of(
            self::class,
            Field::required('palette', Codecs::listOf(PaletteEntry::codec()), fn (self $b) => $b->palette),
        );
    }
}