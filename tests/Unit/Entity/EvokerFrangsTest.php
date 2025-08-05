<?php

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\EvokerFangs;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

describe('EvokerFrangs entity test', function () {
    beforeEach(function () {
        $server = Mockery::mock(Server::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $this->entity = new EvokerFangs($server, new Location(0, 0, 0));
    });

    it('Test entity type', function () {
        expect($this->entity->getType())->toBe(EntityType::EVOKER_FANGS);
    });
});