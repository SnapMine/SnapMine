<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\Attached;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\MultipleFacing;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

class Tripwire extends BlockData
{
    private bool $disarmed = false;

    use Attached, Powerable, MultipleFacing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['disarmed' => $this->disarmed]);
    }

    public function getAllowedFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    /**
     * @param bool $disarmed
     */
    public function setDisarmed(bool $disarmed): void
    {
        $this->disarmed = $disarmed;
    }

    /**
     * @return bool
     */
    public function isDisarmed(): bool
    {
        return $this->disarmed;
    }
}