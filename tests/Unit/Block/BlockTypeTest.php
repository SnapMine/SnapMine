<?php

use Nirbose\PhpMcServ\Block\BlockCoefficient;
use Nirbose\PhpMcServ\Block\BlockType;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Block\Type\Bed\Bed;
use Nirbose\PhpMcServ\Block\Type\Bed\RedBed;
use Nirbose\PhpMcServ\Material;

it('Test createBlockData()', function () {
    BlockCoefficient::load(__DIR__ . '/../../../resources/blocks_coefficients.json');

    /** @var RedBed $bed */
    $bed = BlockType::RED_BED->createBlockData();

    $bed->setPart(Bed::HEAD);
    $bed->setFacing(Direction::EAST);

    expect($bed->computedId())->toBe(1969);

    /** @var BlockData $block */
    $block = BlockType::STONE->createBlockData();

    expect($block->getMaterial())->toBe(Material::STONE);
});