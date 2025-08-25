<?php

namespace SnapMine\Entity;

use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\World\Position;

class EndCrystal extends Entity
{
    private ?Position $target = null;
    private bool $showBottom = true;

    public function getTarget(): ?Position
    {
        return $this->target;
    }

    public function setTarget(?Position $target): void
    {
        $this->target = $target;
    }

    public function showBottom(): bool
    {
        return $this->showBottom;
    }

    public function setShowBottom(bool $showBottom): void
    {
        $this->showBottom = $showBottom;

        $this->setMetadata(9, MetadataType::BOOLEAN, $this->showBottom);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::END_CRYSTAL;
    }
}