<?php

use SnapMine\Entity\AreaEffectCloud;
use SnapMine\Entity\EntityType;
use SnapMine\Server;
use SnapMine\World\Location;
use SnapMine\World\World;

describe('AreaEffectCloud entity', function () {
    /** @var AreaEffectCloud $entity */
    $entity = null;

    beforeEach(function () use (&$entity) {
        $server = Mockery::mock(Server::class);
        $world = Mockery::mock(World::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $entity = new AreaEffectCloud($server, new Location($world, 0, 0, 0));
    });

    it('Test entity type', function () use (&$entity) {
        expect($entity->getType())->toBe(EntityType::AREA_EFFECT_CLOUD);
    });

    it('Test radius', function () use (&$entity) {
        expect($entity->getRadius())->toBe(3.0);

        $entity->setRadius(4.0);

        expect($entity->getRadius())->toBe(4.0);
    });

    it('Test ignore radius', function () use (&$entity) {
        expect($entity->isIgnoreRadius())->toBeFalse();

        $entity->setIgnoreRadius(true);

        expect($entity->isIgnoreRadius())->toBeTrue();
    });
});