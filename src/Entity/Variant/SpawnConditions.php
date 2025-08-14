<?php

namespace Nirbose\PhpMcServ\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use Nirbose\PhpMcServ\Registry\EncodableToNbt;

readonly class SpawnConditions implements EncodableToNbt
{
    public function __construct(
        private array $spawn_conditions
    )
    {
    }

    public function toNbt(): ListTag
    {
        $base = new ListTag();

        foreach ($this->spawn_conditions as $condition) {
            $baseCompound = new CompoundTag();

            if (isset($condition['condition'])) {
                $conditionCompoundTag = new CompoundTag();

                $type = $condition['condition']['type'];

                $conditionCompoundTag->set('type', (new StringTag())->setValue($type));

                $typed = match ($type) {
                    'minecraft:biome' => 'biomes',
                    'minecraft:structure' => 'structures',
                    'minecraft:moon_brightness' => function () use ($condition, $conditionCompoundTag) {
                        $conditionCompoundTag->set(
                            'range',
                            (new CompoundTag())
                                ->set('min', (new FloatTag())->setValue($condition['condition']['range']['min']))
                        );
                    },
                };

                if (!is_callable($typed))
                    $conditionCompoundTag->set($typed, (new StringTag())->setValue($condition['condition'][$typed]));
                else
                    $typed();

                $baseCompound->set('condition', $conditionCompoundTag);
            }

            $baseCompound->set('priority', (new IntTag())->setValue($condition['priority']));
            $base[] = $baseCompound;
        }

        return $base;
    }
}