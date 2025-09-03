<?php

use SnapMine\Entity\EndCrystal;
use SnapMine\Entity\EntityType;
use SnapMine\Server;
use SnapMine\World\Location;
use SnapMine\World\Position;
use SnapMine\World\World;

describe('EndCrystal entity test', function () {
    /** @var EndCrystal $entity */
    $entity = null;

    beforeEach(function () use (&$entity) {
        $server = Mockery::mock(Server::class);
        $world = Mockery::mock(World::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $entity = new EndCrystal($server, new Location($world, 0, 0, 0));
    });

    it('Test entity type', function () use (&$entity) {
        expect($entity->getType())->toBe(EntityType::END_CRYSTAL);
    });

    it('Test target', function () use (&$entity) {
        expect($entity->getTarget())->toBeNull();

        $pos = new Position(0, 0, 0);
        $entity->setTarget($pos);

        expect($entity->getTarget())->toBe($pos);
    });

    it('Show bottom', function () use (&$entity) {
        expect($entity->showBottom())->toBeTrue();

        $entity->setShowBottom(false);
        expect($entity->showBottom())->toBeFalse();
    });
});
