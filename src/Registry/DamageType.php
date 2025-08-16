<?php

namespace Nirbose\PhpMcServ\Registry;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\StringTag;
use Nirbose\PhpMcServ\Keyed;

class DamageType implements EncodableToNbt, Keyed
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
        $base = (new CompoundTag())
            ->set('exhaustion', (new FloatTag())->setValue($this->data['exhaustion']))
            ->set('message_id', (new StringTag())->setValue($this->data['message_id']))
            ->set('scaling', (new StringTag())->setValue($this->data['scaling']));

        if (isset($this->data['effects'])) {
            $base->set('effects', (new StringTag())->setValue($this->data['effects']));
        }

        if (isset($this->data['death_message_type'])) {
            $base->set('death_message_type', (new StringTag())->setValue($this->data['death_message_type']));
        }

        return $base;
    }
}