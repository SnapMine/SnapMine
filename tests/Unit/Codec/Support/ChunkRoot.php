<?php

declare(strict_types=1);

namespace Tests\Unit\Codec\Support;

use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * Test fixture: a chunk root holding a list of sections.
 */
final class ChunkRoot
{
    /** @param list<Section> $sections */
    public function __construct(public readonly array $sections)
    {
    }

    public static function codec(): RecordCodec
    {
        return RecordCodec::of(
            self::class,
            Field::required('sections', Codecs::listOf(Section::codec()), fn (self $r) => $r->sections),
        );
    }
}