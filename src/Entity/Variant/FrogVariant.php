<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Keyed;
use SnapMine\Registry\EncodableToNbt;

/**
 * @method static FrogVariant COLD()
 * @method static FrogVariant TEMPERATE()
 * @method static FrogVariant WARM()
 */
class FrogVariant implements EncodableToNbt, Keyed
{
    /** @var array<string, self> */
    protected static array $entries = [];

    public function __construct(
        protected readonly string $key,
        protected readonly array $data,
        protected readonly int $id,
    )
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public static function register(string $name, string $key, array $data): self
    {
        $instance = new self($key, $data, count(self::$entries));
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
        $base = new CompoundTag();

        $base
            ->set('asset_id', (new StringTag())->setValue($this->data['asset_id']));

        $conditionsTag = (new SpawnConditions($this->data['spawn_conditions']))->toNbt();

        $base->set('spawn_conditions', $conditionsTag);

        return $base;
    }
}