<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Attachment;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Facing;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Direction;

class Bell extends BlockData
{
    private Attachment $attachment = Attachment::FLOOR;

    use Facing, Powerable;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['attachment' => $this->attachment]);
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
     * @param Attachment $attachment
     */
    public function setAttachment(Attachment $attachment): void
    {
        $this->attachment = $attachment;
    }

    /**
     * @return Attachment
     */
    public function getAttachment(): Attachment
    {
        return $this->attachment;
    }
}