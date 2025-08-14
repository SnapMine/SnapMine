<?php

namespace Nirbose\PhpMcServ\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use Nirbose\PhpMcServ\Registry\RegistryData;
use RuntimeException;

/**
 * @method static CatVariant ALL_BLACK()
 * @method static CatVariant BLACK()
 * @method static CatVariant BRITISH_SHORTHAIR()
 * @method static CatVariant CALICO()
 * @method static CatVariant JELLIE()
 * @method static CatVariant PERSIAN()
 * @method static CatVariant RAGDOLL()
 * @method static CatVariant RED()
 * @method static CatVariant SIAMESE()
 * @method static CatVariant TABBY()
 * @method static CatVariant WHITE()
 */
class CatVariant
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
            throw new RuntimeException("TrimMaterial '$name' not found");
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

    public function toNbt(): Tag
    {
        $base = new CompoundTag();

        $base
            ->set('asset_id', (new StringTag())->setValue($this->data['asset_id']))
            ->set('spawn_conditions', (new SpawnConditions($this->data['spawn_conditions']))->toNbt());

        return $base;
    }
}