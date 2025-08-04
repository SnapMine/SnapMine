<?php

use Nirbose\PhpMcServ\Component\TextComponent;
use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Pose;
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

    it('Test customName', function () {
        expect($this->entity->getCustomName())->toBe(null);

        $customName = TextComponent::text("hello");

        $this->entity->setCustomName($customName);
        expect($this->entity->getCustomName())->toBe($customName);
    });

    it('Test customName visibility', function () {
        expect($this->entity->isCustomNameVisible())->toBeFalse();

        $this->entity->setCustomNameVisible(true);

        expect($this->entity->isCustomNameVisible())->toBeTrue();
    });

    it('Test silent', function () {
        expect($this->entity->isSilent())->toBeFalse();

        $this->entity->setSilent(true);

        expect($this->entity->isSilent())->toBeTrue();
    });

    it('Test hasGravity', function () {
        expect($this->entity->hasGravity())->toBeFalse();

        $this->entity->setGravity(true);

        expect($this->entity->hasGravity())->toBeTrue();
    });

    it('Test entity pose', function () {
        expect($this->entity->getPose())->toBe(Pose::STANDING);

        $this->entity->setPose(Pose::DYING);

        expect($this->entity->getPose())->toBe(Pose::DYING);
    });

    it('Test getType', function () {
        expect($this->entity->getType())->toBe(EntityType::ALLAY);
    });
});