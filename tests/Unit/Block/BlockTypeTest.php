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