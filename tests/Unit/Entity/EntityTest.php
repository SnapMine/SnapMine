<?php

use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

describe('Test Entity class', function () {
    beforeEach(function () {
        $server = Mockery::mock(Server::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $this->entity = new class($server) extends Entity {
            public function __construct(Server $server)
            {
                parent::__construct($server, new Location(0, 0, 0));
            }

            function getType(): EntityType
            {
                return EntityType::ALLAY;
            }
        };
    });

    it('Test getId', function () {
        expect($this->entity->getId())->toBe(1);
    });

    it('Test entity is on fire', function () {
        expect($this->entity->isOnFire())->toBeFalse();

        $this->entity->setOnFire(true);

        expect($this->entity->isOnFire())->toBeTrue();

        $this->entity->setOnFire(false);

        expect($this->entity->isOnFire())->toBeFalse();
    });

    it('Test entity is sneaking', function () {
        expect($this->entity->isSneaking())->toBeFalse();

        $this->entity->setSneaking(true);

        expect($this->entity->isSneaking())->toBeTrue();
    });

    it('Test entity is sprinting', function () {
        expect($this->entity->isSprinting())->toBeFalse();

        $this->entity->setSprinting(true);

        expect($this->entity->isSprinting())->toBeTrue();
    });

    it('Test entity is swimming', function () {
        expect($this->entity->isSwimming())->toBeFalse();

        $this->entity->setSwimming(true);

        expect($this->entity->isSwimming())->toBeTrue();
    });

    it('Test entity is invisible', function () {
        expect($this->entity->isInvisible())->toBeFalse();

        $this->entity->setInvisible(true);

        expect($this->entity->isInvisible())->toBeTrue();
    });

    it('Test entity is glowing', function () {
        expect($this->entity->isGlowing())->toBeFalse();

        $this->entity->setGlowing(true);

        expect($this->entity->isGlowing())->toBeTrue();
    });

    it('Test getType', function () {
        expect($this->entity->getType())->toBe(EntityType::ALLAY);
    });
});