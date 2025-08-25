<?php

namespace SnapMine\World;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\DoubleTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Keyed;
use SnapMine\Registry\EncodableToNbt;

class Biome implements EncodableToNbt, Keyed
{
    /** @var array<string, self> */
    protected static array $entries = [];

    public function __construct(
        protected readonly string $key,
        protected readonly array  $data,
    )
    {
    }

    public static function register(string $name, string $key, array $data): self
    {
        $instance = new self($key, $data);
        self::$entries[strtoupper($name)] = $instance;

        return $instance;
    }

    public static function __callStatic(string $name, array $args): self
    {
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
            ->set('downfall', (new FloatTag())->setValue($this->data['downfall']))
            ->set('has_precipitation', (new ByteTag())->setValue($this->data['has_precipitation']))
            ->set('temperature', (new FloatTag())->setValue($this->data['temperature']));

        if (is_string($this->data['carvers'])) {
            $base->set('carvers', (new StringTag())->setValue($this->data['carvers']));
        } else {
            $carvers = new ListTag();

            foreach ($this->data['carvers'] as $carver) {
                $carvers[] = (new StringTag())->setValue($carver);
            }

            $base->set('carvers', $carvers);
        }

        $effects = (new CompoundTag())
            ->set('fog_color', (new IntTag())->setValue($this->data['effects']['fog_color']))
            ->set('music_volume', (new FloatTag())->setValue($this->data['effects']['music_volume']))
            ->set('sky_color', (new IntTag())->setValue($this->data['effects']['sky_color']))
            ->set('water_color', (new IntTag())->setValue($this->data['effects']['water_color']))
            ->set('water_fog_color', (new IntTag())->setValue($this->data['effects']['water_fog_color']))
            ->set('mood_sound', (new CompoundTag())
                ->set('block_search_extent', (new IntTag())->setValue($this->data['effects']['mood_sound']['block_search_extent']))
                ->set('offset', (new DoubleTag())->setValue($this->data['effects']['mood_sound']['offset']))
                ->set('sound', (new StringTag())->setValue($this->data['effects']['mood_sound']['sound']))
                ->set('tick_delay', (new IntTag())->setValue($this->data['effects']['mood_sound']['tick_delay']))
            )
            ->set('music', $this->encodeMusicEffects());

        $base->set('effects', $effects);

        return $base;
    }

    private function encodeMusicEffects(): ListTag
    {
        $list = new ListTag();

        if (!isset($this->data['effects']['music']))
            return $list;

        foreach ($this->data['effects']['music'] as $music) {
            $list[] = (new CompoundTag())
                ->set('data', (new CompoundTag())
                    ->set('max_delay', (new IntTag())->setValue($music['data']['max_delay']))
                    ->set('min_delay', (new IntTag())->setValue($music['data']['min_delay']))
                    ->set('replace_current_music', (new ByteTag())->setValue($music['data']['replace_current_music']))
                    ->set('sound', (new StringTag())->setValue($music['data']['sound']))
                )
                ->set('weight', (new IntTag())->setValue($music['weight']));
        }

        return $list;
    }
}