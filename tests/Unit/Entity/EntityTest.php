<?php

use Nirbose\PhpMcServ\Component\TextComponent;
use Nirbose\PhpMcServ\Entity\Entity;
use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\Pose;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

describe('Test Entity class', function () {
    /** @var Entity */
    $entity = null;

    beforeEach(function () use (&$entity) {
        $server = Mockery::mock(Server::class);
        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $entity = new class($server) extends Entity {
            public function __construct(Server $server)
            {
                parent::__construct($server, new Location(0, 0, 0));
            }

            public function getType(): EntityType
            {
                return EntityType::ALLAY;
            }
        };
    });

    it('Test getId', function () use (&$entity) {
        expect($entity->getId())->toBe(1);
    });

    it('Test entity is on fire', function () use (&$entity) {
        expect($entity->isOnFire())->toBeFalse();

        $entity->setOnFire(true);
        expect($entity->isOnFire())->toBeTrue();

        $entity->setOnFire(false);
        expect($entity->isOnFire())->toBeFalse();
    });

    it('Test entity is sneaking', function () use (&$entity) {
        expect($entity->isSneaking())->toBeFalse();

        $entity->setSneaking(true);
        expect($entity->isSneaking())->toBeTrue();
    });

    it('Test entity is sprinting', function () use (&$entity) {
        expect($entity->isSprinting())->toBeFalse();

        $entity->setSprinting(true);
        expect($entity->isSprinting())->toBeTrue();
    });

    it('Test entity is swimming', function () use (&$entity) {
        expect($entity->isSwimming())->toBeFalse();

        $entity->setSwimming(true);
        expect($entity->isSwimming())->toBeTrue();
    });

    it('Test entity is invisible', function () use (&$entity) {
        expect($entity->isInvisible())->toBeFalse();

        $entity->setInvisible(true);
        expect($entity->isInvisible())->toBeTrue();
    });

    it('Test entity is glowing', function () use (&$entity) {
        expect($entity->isGlowing())->toBeFalse();

        $entity->setGlowing(true);
        expect($entity->isGlowing())->toBeTrue();
    });

    it('Test air ticks', function () use (&$entity) {
        expect($entity->getAirTicks())->toBe(300);

        $entity->setAirTicks(400);
        expect($entity->getAirTicks())->toBe(400);
    });

    it('Test customName', function () use (&$entity) {
        expect($entity->getCustomName())->toBeNull();

        $customName = TextComponent::text("hello");

        $entity->setCustomName($customName);
        expect($entity->getCustomName())->toBe($customName);
    });

    it('Test customName visibility', function () use (&$entity) {
        expect($entity->isCustomNameVisible())->toBeFalse();

        $entity->setCustomNameVisible(true);
        expect($entity->isCustomNameVisible())->toBeTrue();
    });

    it('Test silent', function () use (&$entity) {
        expect($entity->isSilent())->toBeFalse();

        $entity->setSilent(true);
        expect($entity->isSilent())->toBeTrue();
    });

    it('Test hasGravity', function () use (&$entity) {
        expect($entity->hasGravity())->toBeFalse();

        $entity->setGravity(true);
        expect($entity->hasGravity())->toBeTrue();
    });

    it('Test entity pose', function () use (&$entity) {
        expect($entity->getPose())->toBe(Pose::STANDING);

        $entity->setPose(Pose::DYING);
        expect($entity->getPose())->toBe(Pose::DYING);
    });

    it('Test getType', function () use (&$entity) {
        expect($entity->getType())->toBe(EntityType::ALLAY);
    });
});
