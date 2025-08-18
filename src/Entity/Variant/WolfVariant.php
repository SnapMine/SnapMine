<?php

namespace Nirbose\PhpMcServ\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\StringTag;
use Nirbose\PhpMcServ\Keyed;
use Nirbose\PhpMcServ\Registry\EncodableToNbt;

/**
 * @method static WolfVariant ASHEN()
 * @method static WolfVariant BLACK()
 * @method static WolfVariant CHESTNUT()
 * @method static WolfVariant PALE()
 * @method static WolfVariant RUSTY()
 * @method static WolfVariant SNOWY()
 * @method static WolfVariant SPOTTED()
 * @method static WolfVariant STRIPED()
 * @method static WolfVariant WOODS()
 */
class WolfVariant implements EncodableToNbt, Keyed
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
        $base = new CompoundTag();

        $base
            ->set('assets', (new CompoundTag())
                ->set('angry', (new StringTag())->setValue($this->data['assets']['angry']))
                ->set('tame', (new StringTag())->setValue($this->data['assets']['tame']))
                ->set('wild', (new StringTag())->setValue($this->data['assets']['wild']))
            );

        $conditionsTag = (new SpawnConditions($this->data['spawn_conditions']))->toNbt();

        $base->set('spawn_conditions', $conditionsTag);

        return $base;
    }
}