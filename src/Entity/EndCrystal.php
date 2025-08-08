<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Entity\Metadata\MetadataType;
use Nirbose\PhpMcServ\World\Position;

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
    function getType(): EntityType
    {
        return EntityType::END_CRYSTAL;
    }
}