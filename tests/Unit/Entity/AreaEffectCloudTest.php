<?php

use Nirbose\PhpMcServ\Entity\AreaEffectCloud;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

describe('AreaEffectCloud entity', function () {
    beforeEach(function () {
        $server = Mockery::mock(Server::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $this->entity = new AreaEffectCloud($server, new Location(0, 0, 0));
    });

    it('Test entity type', function () {
        expect($this->entity->getType())->toBe(EntityType::AREA_EFFECT_CLOUD);
    });

    it('Test radius', function () {
        expect($this->entity->getRadius())->toBe(3.0);

        $this->entity->setRadius(4.0);

        expect($this->entity->getRadius())->toBe(4.0);
    });

    it('Test ignore radius', function () {
        expect($this->entity->isIgnoreRadius())->toBeFalse();

        $this->entity->setIgnoreRadius(true);

        expect($this->entity->isIgnoreRadius())->toBeTrue();
    });
});