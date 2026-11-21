<?php

declare(strict_types=1);

namespace SnapMine\Entity\Variant;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

final class SpawnConditions implements CodecProvider
{
    public function __construct(
        private readonly int $priority,
        private readonly ?SpawnCondition $condition = null,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('priority', Codecs::int(), fn (self $s) => $s->priority),
            Field::optional('condition', SpawnCondition::codec(), fn (self $s) => $s->condition),
        );
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getCondition(): ?SpawnCondition
    {
        return $this->condition;
    }
}
