<?php

namespace SnapMine\Block\Type;

use InvalidArgumentException;
use SnapMine\Block\Connection;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Power;
use SnapMine\Block\Direction;

class RedstoneWire extends BlockData
{
    /** @var array<string, Connection> */
    private array $connections = [];

    use Power;

    public function computedId(array $data = []): int
    {
        /** @var Direction[] $directions */
        $directions = [Direction::NORTH, Direction::EAST, Direction::WEST, Direction::SOUTH];

        foreach ($directions as $direction) {
            $data[$direction->value] = $this->getConnection($direction);
        }

        return parent::computedId($data);
    }

    public function getConnection(Direction $direction): Connection
    {
        if ($direction == Direction::UP || $direction == Direction::DOWN) {
            throw new InvalidArgumentException('Direction should not be up or down');
        }

        if (isset($this->connections[$direction->value])) {
            return $this->connections[$direction->value];
        }

        return Connection::NONE;
    }

    public function setConnection(Direction $direction, Connection $connection): void
    {
        if ($direction == Direction::UP || $direction == Direction::DOWN) {
            throw new InvalidArgumentException('Direction should not be up or down');
        }

        $this->connections[$direction->value] = $connection;
    }
}