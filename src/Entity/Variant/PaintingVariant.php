<?php

namespace SnapMine\Entity\Variant;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

class PaintingVariant extends RegistryData implements NbtSerializable
{

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