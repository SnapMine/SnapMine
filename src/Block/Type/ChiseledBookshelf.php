<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Direction;

class ChiseledBookshelf extends BlockData
{
    /** @var bool[]  */
    private array $slots = [false, false, false, false, false, false];

    use Facing;

    public function computedId(array $data = []): int
    {
        foreach ($this->slots as $slot => $value) {
            $data['slot_' . $slot . '_occupied'] = $value;
        }

        return parent::computedId($data);
    }

    public function getFaces(): array
    {
        return [
            Direction::EAST,
            Direction::WEST,
            Direction::NORTH,
            Direction::SOUTH,
        ];
    }

    /**
     * @return array
     */
    public function getSlots(): array
    {
        return $this->slots;
    }

    /**
     * @param int $slot
     * @param bool $occupied
     */
    public function setSlots(int $slot, bool $occupied): void
    {
        $this->slots[$slot] = $occupied;
    }

    public function hasSlot(int $slot): bool
    {
        return $this->slots[$slot];
    }
}