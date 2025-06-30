<?php

namespace Nirbose\PhpMcServ\Manager;

use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\KeepAlivePacket;
use Nirbose\PhpMcServ\Server;

class KeepAliveManager implements Manager
{
    private int $interval = 15; // secondes
    private int $lastSent = 0;

    public function tick(Server $server): void {
        $now = time();
        if ($now - $this->lastSent >= $this->interval) {
            $this->lastSent = $now;

            foreach ($server->getPlayers() as $player) {
                $keepAliveId = $now;

                $packet = new KeepAlivePacket($keepAliveId);
                $player->sendPacket($packet);

                $player->lastKeepAliveId = $keepAliveId;
            }
        }
    }
}