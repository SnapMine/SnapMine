<?php

use SnapMine\Entity\EntityType;
use SnapMine\Entity\WindCharge;
use SnapMine\Server;
use SnapMine\World\Location;
use SnapMine\World\World;

describe('WindCharge entity test', function () {
    /** @var WindCharge $entity */
    $entity = null;

    beforeEach(function () use (&$entity) {
        $server = Mockery::mock(Server::class);
        $world = Mockery::mock(World::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $entity = new WindCharge($server, new Location($world, 0, 0, 0));
    });

    it('Test entity type', function () use (&$entity) {
        expect($entity->getType())->toBe(EntityType::WIND_CHARGE);
    });
});