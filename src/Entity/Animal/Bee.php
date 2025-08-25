<?php

namespace SnapMine\Entity\Animal;

use SnapMine\Entity\Animal\Animal;
use SnapMine\Entity\EntityType;
use SnapMine\Entity\Metadata\MetadataType;

class Bee extends Animal
{
    protected int $beeFlags = 0;
    protected int $angerTime = 0;

    public const FLAG_UNUSED   = 0x01;
    public const FLAG_ANGRY    = 0x02;
    public const FLAG_HAS_STUNG = 0x04;
    public const FLAG_HAS_NECTAR = 0x08;

    private function addBeeFlag(int $flag): void
    {
        $this->beeFlags |= $flag;
        $this->setMetadata(17, MetadataType::BYTE, $this->beeFlags);
    }

    private function removeBeeFlag(int $flag): void
    {
        $this->beeFlags &= ~$flag;
        $this->setMetadata(17, MetadataType::BYTE, $this->beeFlags);
    }

    private function hasBeeFlag(int $flag): bool
    {
        return ($this->beeFlags & $flag) !== 0;
    }

    public function setAngry(bool $angry): void
    {
        if ($angry) {
            $this->addBeeFlag(self::FLAG_ANGRY);
        } else {
            $this->removeBeeFlag(self::FLAG_ANGRY);
        }
    }

    public function isAngry(): bool
    {
        return $this->hasBeeFlag(self::FLAG_ANGRY);
    }

    public function setHasStung(bool $stung): void
    {
        if ($stung) {
            $this->addBeeFlag(self::FLAG_HAS_STUNG);
        } else {
            $this->removeBeeFlag(self::FLAG_HAS_STUNG);
        }
    }

    public function hasStung(): bool
    {
        return $this->hasBeeFlag(self::FLAG_HAS_STUNG);
    }

    public function setHasNectar(bool $nectar): void
    {
        if ($nectar) {
            $this->addBeeFlag(self::FLAG_HAS_NECTAR);
        } else {
            $this->removeBeeFlag(self::FLAG_HAS_NECTAR);
        }
    }

    public function hasNectar(): bool
    {
        return $this->hasBeeFlag(self::FLAG_HAS_NECTAR);
    }

    public function getAngerTime(): int
    {
        return $this->angerTime;
    }

    public function setAngerTime(int $ticks): void
    {
        $this->angerTime = $ticks;
        $this->setMetadata(18, MetadataType::VAR_INT, $this->angerTime);
    }

    /**
     * @inheritDoc
     */
    public function getType(): EntityType
    {
        return EntityType::BEE;
    }
}