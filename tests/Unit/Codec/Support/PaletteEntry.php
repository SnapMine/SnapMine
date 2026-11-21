<?php

declare(strict_types=1);

namespace Tests\Unit\Codec\Support;

use SnapMine\Codec\Codec;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * Test fixture: a block state entry with an optional property map.
 */
final class PaletteEntry
{
    /** @param array<string, string>|null $Properties */
    public function __construct(
        public readonly string $Name,
        public readonly ?array $Properties = null,
    ) {
    }

    public static function codec(): RecordCodec
    {
        return RecordCodec::of(
            self::class,
            Field::required('Name', Codecs::string(), fn (self $e) => $e->Name),
            Field::optional('Properties', Codecs::mapOf(Codecs::string()), fn (self $e) => $e->Properties),
        );
    }
}