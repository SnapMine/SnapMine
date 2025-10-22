<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\StringTag;
use SnapMine\Component\TextComponent;
use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\Nbt\NbtTag;
use SnapMine\NbtSerializable;

class ChatData implements NbtSerializable
{
    #[NbtTag(StringTag::class, 'translation_key')]
    private string $translationKey;

    #[NbtList('parameters', 'string')]
    private array $parameters;

    #[NbtCompound('style')]
    private ?TextComponent $style = null;
}