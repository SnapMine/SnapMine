<?php

declare(strict_types=1);

namespace Tests\Unit\Codec\Support;

use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * Test fixture: an individual chunk section.
 */
final class Section
{
    public function __construct(public readonly BlockStates $blockStates)
    {
    }

    public static function codec(): RecordCodec
    {
        return RecordCodec::of(
            self::class,
            Field::required('block_states', BlockStates::codec(), fn (self $s) => $s->blockStates),
        );
    }
}