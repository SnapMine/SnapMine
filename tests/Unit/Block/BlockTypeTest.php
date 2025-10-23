<?php

use SnapMine\Block\BlockType;
use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Direction;
use SnapMine\Block\Type\Bed;
use SnapMine\Material;

it('Test createBlockData()', function () {
    \server();

    /** @var Bed $bed */
    $bed = BlockType::RED_BED->createBlockData();

    $bed->setPart(Bed::HEAD);
    $bed->setFacing(Direction::EAST);

    expect($bed->computedId())->toBe(1969);

    /** @var BlockData $block */
    $block = BlockType::STONE->createBlockData();

    expect($block->getMaterial())->toBe(Material::STONE);
});

test('Test chest getId', function () {
    \server();

    /** @var \SnapMine\Block\Type\Chest $chest */
    $chest = BlockType::CHEST->createBlockData();

    $chest->setWaterlogged(false);
    $chest->setFacing(Direction::WEST);
    $chest->setType('single');

    expect($chest->getMaterial()->getBlockId())->toBe(3018)
        ->and($chest->computedId())->toBe(3031);

    $chest->setWaterlogged(false);
    $chest->setFacing(Direction::WEST);
    $chest->setType('right');

    expect($chest->computedId())->toBe(3035);

    $chest->setWaterlogged(false);
    $chest->setFacing(Direction::WEST);
    $chest->setType('left');

    expect($chest->computedId())->toBe(3033);
});