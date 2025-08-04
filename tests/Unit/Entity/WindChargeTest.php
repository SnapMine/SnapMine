<?php

use Nirbose\PhpMcServ\Entity\EntityType;
use Nirbose\PhpMcServ\Entity\WindCharge;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\World\Location;

describe('WindCharge entity test', function () {
    beforeEach(function () {
        $server = Mockery::mock(Server::class);

        $server->shouldReceive('incrementAndGetId')->andReturn(1);

        $this->entity = new WindCharge($server, new Location(0, 0, 0));
    });

    it('Test entity type', function () {
        expect($this->entity->getType())->toBe(EntityType::WIND_CHARGE);
    });
});