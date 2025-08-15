<?php

namespace Nirbose\PhpMcServ\World;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use Nirbose\PhpMcServ\Registry\RegistryData;

class DimensionType
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

    public function toNbt(): Tag
    {
        $base = (new CompoundTag())
            ->set('ambient_light', (new FloatTag())->setValue($this->data['ambient_light']))
            ->set('bed_works', (new ByteTag())->setValue($this->data['bed_works']))
            ->set('coordinate_scale', (new FloatTag())->setValue($this->data['coordinate_scale']))
            ->set('effects', (new StringTag())->setValue($this->data['effects']))
            ->set('has_ceiling', (new ByteTag())->setValue($this->data['has_ceiling']))
            ->set('has_raids', (new ByteTag())->setValue($this->data['has_raids']))
            ->set('has_skylight', (new ByteTag())->setValue($this->data['has_skylight']))
            ->set('height', (new IntTag())->setValue($this->data['height']))
            ->set('infiniburn', (new StringTag())->setValue($this->data['infiniburn']))
            ->set('logical_height', (new IntTag())->setValue($this->data['logical_height']))
            ->set('min_y', (new IntTag())->setValue($this->data['min_y']))
            ->set('monster_spawn_block_light_limit', (new IntTag())->setValue($this->data['monster_spawn_block_light_limit']))
            ->set('natural', (new ByteTag())->setValue($this->data['natural']))
            ->set('piglin_safe', (new ByteTag())->setValue($this->data['piglin_safe']))
            ->set('respawn_anchor_works', (new ByteTag())->setValue($this->data['respawn_anchor_works']))
            ->set('ultrawarm', (new ByteTag())->setValue($this->data['ultrawarm']));

        if (is_int($this->data['monster_spawn_light_level'])) {
            $base->set('monster_spawn_light_level', (new IntTag())->setValue($this->data['monster_spawn_light_level']));
        } else {
            $base->set('monster_spawn_light_level', (new CompoundTag())
                ->set('type', (new StringTag())->setValue($this->data['monster_spawn_light_level']['type']))
                ->set('max_inclusive', (new IntTag())->setValue($this->data['monster_spawn_light_level']['max_inclusive']))
                ->set('min_inclusive', (new IntTag())->setValue($this->data['monster_spawn_light_level']['min_inclusive']))
            );
        }

        if (isset($this->data['fixed_time'])) {
            $base->set('fixed_time', (new IntTag())->setValue($this->data['fixed_time']));
        }

        return $base;
    }
}