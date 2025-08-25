<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use SnapMine\Keyed;
use SnapMine\Registry\EncodableToNbt;

class PaintingVariant implements EncodableToNbt, Keyed
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
        $base = new CompoundTag();

        $base
            ->set('asset_id', (new StringTag())->setValue($this->data['asset_id']))
            ->set('height', (new IntTag())->setValue($this->data['height']))
            ->set('width', (new IntTag())->setValue($this->data['width']));

        if (isset($this->data['author'])) {
            $author = (new CompoundTag())
                ->set('color', (new StringTag())->setValue($this->data['author']['color']))
                ->set('translate', (new StringTag())->setValue($this->data['author']['translate']));

            $base->set('author', $author);
        }

        $title = (new CompoundTag())
            ->set('color', (new StringTag())->setValue($this->data['title']['color']))
            ->set('translate', (new StringTag())->setValue($this->data['title']['translate']));

        $base->set('title', $title);

        return $base;
    }
}