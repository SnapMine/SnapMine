<?php

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\BlockType;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Block\Type\Bed;
use Nirbose\PhpMcServ\Material;

it('Test createBlockData()', function () {
    $loader = new BlockStateLoader(__DIR__ . '/../../../resources/blocks.json');

    /** @var Bed $bed */
    $bed = BlockType::RED_BED->createBlockData();

    $bed->setPart(Bed::HEAD);
    $bed->setFacing(Direction::EAST);

    expect($bed->computedId($loader))->toBe(1969);

    /** @var BlockData $block */
    $block = BlockType::STONE->createBlockData();

    expect($block->getMaterial())->toBe(Material::STONE);
});

test('Test chest getId', function () {
    $loader = new BlockStateLoader(__DIR__ . '/../../../resources/blocks.json');

    /** @var \Nirbose\PhpMcServ\Block\Type\Chest $chest */
    $chest = BlockType::CHEST->createBlockData();

    $chest->setWaterlogged(false);
    $chest->setFacing(Direction::WEST);
    $chest->setType('single');

    expect($chest->getMaterial()->getBlockId())->toBe(3018)
        ->and($chest->computedId($loader))->toBe(3031);

    $chest->setWaterlogged(false);
    $chest->setFacing(Direction::WEST);
    $chest->setType('right');

    expect($chest->computedId($loader))->toBe(3035);

    $chest->setWaterlogged(false);
    $chest->setFacing(Direction::WEST);
    $chest->setType('left');

    expect($chest->computedId($loader))->toBe(3033);
});