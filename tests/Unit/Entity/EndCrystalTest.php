<?php

use Nirbose\PhpMcServ\Entity\EndCrystal;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;
use Nirbose\PhpMcServ\World\Position;

describe('EndCrystal entity test', function () {
    /** @var EndCrystal */
    $entity = null;

    beforeEach(function () use (&$entity) {
        $server = Mockery::mock(Server::class);
        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $entity = new EndCrystal($server, new Location(0, 0, 0));
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
