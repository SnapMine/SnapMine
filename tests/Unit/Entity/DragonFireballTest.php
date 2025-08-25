<?php

use SnapMine\Entity\DragonFireball;
use SnapMine\Entity\EntityType;
use SnapMine\Server;
use SnapMine\World\Location;

describe('DragonFireball entity test', function () {
    /** @var DragonFireball $entity */
    $entity = null;

    beforeEach(function () use (&$entity) {
        $server = Mockery::mock(Server::class);
        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $entity = new DragonFireball($server, new Location(0, 0, 0));
    });

    it('Test entity type', function () use (&$entity) {
        expect($entity->getType())->toBe(EntityType::DRAGON_FIREBALL);
    });
});