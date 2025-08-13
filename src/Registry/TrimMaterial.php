<?php

namespace Nirbose\PhpMcServ\Registry;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use Nirbose\PhpMcServ\Keyed;
use RuntimeException;

/**
 * @method static TrimMaterial AMETHYST()
 * @method static TrimMaterial COPPER()
 * @method static TrimMaterial DIAMOND()
 * @method static TrimMaterial EMERALD()
 * @method static TrimMaterial GOLD()
 * @method static TrimMaterial IRON()
 * @method static TrimMaterial LAPIS()
 * @method static TrimMaterial NETHERITE()
 * @method static TrimMaterial QUARTZ()
 * @method static TrimMaterial REDSTONE()
 * @method static TrimMaterial RESIN()
 */
class TrimMaterial implements Keyed
{
    /** @var array<string, self> */
    private static array $registry = [];

    public function __construct(
        private readonly string $key,
        private readonly array $data,
    )
    {
    }

    public static function register(string $name, string $key, array $data): self
    {
        $instance = new self($key, $data);
        self::$registry[strtoupper($name)] = $instance;

        return $instance;
    }

    public static function __callStatic(string $name, array $args): self {
        $name = strtoupper($name);
        if (!isset(self::$registry[$name])) {
            throw new RuntimeException("TrimMaterial '$name' not found");
        }

        return self::$registry[$name];
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function toNbt(): CompoundTag
    {
        $base = new CompoundTag();

        $base
            ->set('asset_name', (new StringTag())->setValue($this->data['asset_name']))
            ->set('description', (new CompoundTag())
                ->set('color', (new StringTag())->setValue($this->data['description']['color']))
                ->set('translate', (new StringTag())->setValue($this->data['description']['translate']))
            );

        return $base;
    }
}