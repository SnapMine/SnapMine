<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Keyed;
use SnapMine\Registry\EncodableToNbt;

class WolfSoundVariant implements EncodableToNbt, Keyed
{
    /** @var array<string, self> */
    protected static array $entries = [];

    public function __construct(
        protected readonly string $key,
        protected readonly array $data,
    )
    {
    }

    public static function register(string $name, string $key, array $data): self
    {
        $instance = new self($key, $data);
        self::$entries[strtoupper($name)] = $instance;

        return $instance;
    }

    public static function __callStatic(string $name, array $args): self {
        $name = strtoupper($name);
        if (!isset(self::$entries[$name])) {
            throw new \RuntimeException("TrimMaterial '$name' not found");
        }

        return self::$entries[$name];
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public static function getEntries(): array
    {
        return self::$entries;
    }

    public function toNbt(): CompoundTag
    {
        return (new CompoundTag())
            ->set('ambient_sound', (new StringTag())->setValue($this->data['ambient_sound']))
            ->set('death_sound', (new StringTag())->setValue($this->data['death_sound']))
            ->set('growl_sound', (new StringTag())->setValue($this->data['growl_sound']))
            ->set('hurt_sound', (new StringTag())->setValue($this->data['hurt_sound']))
            ->set('pant_sound', (new StringTag())->setValue($this->data['pant_sound']))
            ->set('whine_sound', (new StringTag())->setValue($this->data['whine_sound']));
    }
}