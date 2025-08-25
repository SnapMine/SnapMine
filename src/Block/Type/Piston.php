<?php

namespace Nirbose\PhpMcServ\Block\Type;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Data\Facing;
use Nirbose\PhpMcServ\Block\Direction;

class Piston extends BlockData
{
    private bool $extended = false;

    use Facing;

    public function computedId(array $data = []): int
    {
        return parent::computedId(['extended' => $this->extended]);
    }

    public function getFaces(): array
    {
        return Direction::cases();
    }

    /**
     * @param bool $extended
     */
    public function setExtended(bool $extended): void
    {
        $this->extended = $extended;
    }

    /**
     * @return bool
     */
    public function isExtended(): bool
    {
        return $this->extended;
    }
}