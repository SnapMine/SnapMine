<?php

use Nirbose\PhpMcServ\Entity\EndCrystal;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;
use Nirbose\PhpMcServ\World\Position;

describe('EndCrystal entity test', function () {
    beforeEach(function () {
        $server = Mockery::mock(Server::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $this->entity = new EndCrystal($server, new Location(0, 0, 0));
    });

    it('Test entity type', function () {
        expect($this->entity->getType())->toBe(EntityType::END_CRYSTAL);
    });

    it('Test target', function () {
        expect($this->entity->getTarget())->toBeNull();

        $pos = new Position(0, 0, 0);

        $this->entity->setTarget($pos);

        expect($this->entity->getTarget())->toBe($pos);
    });

    it('Show bottom', function () {
        expect($this->entity->showBottom())->toBeTrue();

        $this->entity->setShowBottom(false);

        expect($this->entity->showBottom())->toBeFalse();
    });
});