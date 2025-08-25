<?php

namespace Nirbose\PhpMcServ\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use Nirbose\PhpMcServ\Keyed;
use Nirbose\PhpMcServ\Registry\EncodableToNbt;

/**
 * @method static ChickenVariant COLD()
 * @method static ChickenVariant TEMPERATE()
 * @method static ChickenVariant WARM()
 */
class ChickenVariant implements EncodableToNbt, Keyed
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function toNbt(): Tag
    {
        $base = (new CompoundTag())
            ->set('asset_id', (new StringTag())->setValue($this->data['asset_id']));

        if (isset($this->data['model']))
            $base->set('model', (new StringTag())->setValue($this->data['model']));

        $base->set('spawn_conditions', (new SpawnConditions($this->data['spawn_conditions']))->toNbt());

        return $base;
    }
}