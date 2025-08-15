<?php

use Nirbose\PhpMcServ\Entity\DragonFireball;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

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