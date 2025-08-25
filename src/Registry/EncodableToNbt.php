<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\Tag;

interface EncodableToNbt
{
    public function toNbt(): Tag;
}