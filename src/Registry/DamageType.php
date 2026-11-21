<?php

declare(strict_types=1);

namespace SnapMine\Registry;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Codecs;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * @extends RegistryData<DamageType>
 */
final class DamageType extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly float $exhaustion = 0.0,
        private readonly string $messageId = '',
        private readonly string $scaling = '',
        private readonly ?string $effects = null,
        private readonly ?string $deathMessageType = null,
    ) {
    }

    /**
     * The single declaration used to decode AND encode a DamageType,
     * whatever the format (registry JSON, NBT of the Registry Data packet...).
     *
     * The field order is the constructor argument order.
     */
    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::withDefault('exhaustion', Codecs::float(), 0.0, fn (self $d) => $d->exhaustion),
            Field::required('message_id', Codecs::string(), fn (self $d) => $d->messageId),
            Field::required('scaling', Codecs::string(), fn (self $d) => $d->scaling),
            Field::optional('effects', Codecs::string(), fn (self $d) => $d->effects),
            Field::optional('death_message_type', Codecs::string(), fn (self $d) => $d->deathMessageType),
        );
    }

    public function getExhaustion(): float
    {
        return $this->exhaustion;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getScaling(): string
    {
        return $this->scaling;
    }

    public function getEffects(): ?string
    {
        return $this->effects;
    }

    public function getDeathMessageType(): ?string
    {
        return $this->deathMessageType;
    }
}
