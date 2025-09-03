<?php

use SnapMine\Entity\EntityType;
use SnapMine\Entity\EvokerFangs;
use SnapMine\Server;
use SnapMine\World\Location;
use SnapMine\World\World;

describe('EvokerFrangs entity test', function () {
    /** @var EvokerFangs $entity */
    $entity = null;

    beforeEach(function () use (&$entity) {
        $server = Mockery::mock(Server::class);
        $world = Mockery::mock(World::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $entity = new EvokerFangs($server, new Location($world, 0, 0, 0));
    });

    it('Test entity type', function () use (&$entity) {
        expect($entity->getType())->toBe(EntityType::EVOKER_FANGS);
    });
});