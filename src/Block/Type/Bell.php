<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Attachment;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Data\Powerable;
use Nirbose\PhpMcServ\Block\Direction;

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