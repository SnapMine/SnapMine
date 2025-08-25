<?php

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Block\BlockType;
use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Direction;
use Nirbose\PhpMcServ\Block\Type\Bed;
use Nirbose\PhpMcServ\Material;
use Nirbose\PhpMcServ\Server;

it('Test createBlockData()', function () {
    $loader = new BlockStateLoader(__DIR__ . '/../../../resources/blocks.json');

    $server = Mockery::mock(Server::class);
    $server->shouldReceive('getBlockStateLoader')->andReturn($loader);
    Artisan::setServer($server);

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
    $loader = new BlockStateLoader(__DIR__ . '/../../../resources/blocks.json');

    $server = Mockery::mock(Server::class);
    $server->shouldReceive('getBlockStateLoader')->andReturn($loader);
    Artisan::setServer($server);

    /** @var \Nirbose\PhpMcServ\Block\Type\Chest $chest */
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