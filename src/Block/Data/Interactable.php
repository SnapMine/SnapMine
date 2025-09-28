<?php

namespace SnapMine\Block\Data;

use SnapMine\Block\Block;
use SnapMine\Entity\Player;

interface Interactable
{
    public function interact(Player $player, Block $block): bool;
}