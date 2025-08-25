<?php

namespace SnapMine\Entity\Mob;

use SnapMine\Entity\LivingEntity;
use SnapMine\Entity\Metadata\MetadataType;

abstract class Mob extends LivingEntity
{
    protected int $flags = 0;

    public function hasAI(): bool
    {
        return ($this->flags & 0x01) === 0x01;
    }

    public function setAI(bool $flag): void
    {
        if ($flag) {
            $this->flags |= 0x01;
        } else {
            $this->flags &= ~0x01;
        }
        $this->updateFlags();
    }

    public function isLeftHanded(): bool
    {
        return ($this->flags & 0x02) === 0x02;
    }

    public function setLeftHanded(bool $flag): void
    {
        if ($flag) {
            $this->flags |= 0x02;
        } else {
            $this->flags &= ~0x02;
        }

        $this->updateFlags();
    }

    public function isAggressive(): bool
    {
        return ($this->flags & 0x04) === 0x04;
    }

    public function setAggressive(bool $flag): void
    {
        if ($flag) {
            $this->flags |= 0x04;
        } else {
            $this->flags &= ~0x04;
        }

        $this->updateFlags();
    }

    private function updateFlags(): void
    {
        $this->setMetadata(15, MetadataType::BYTE, $this->flags);
    }
}