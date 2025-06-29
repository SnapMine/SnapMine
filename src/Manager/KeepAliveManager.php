<?php

namespace Nirbose\PhpMcServ\Manager;

use Nirbose\PhpMcServ\Packet\Clientbound\Play\KeepAlivePacket;
use Nirbose\PhpMcServ\Server;

class KeepAliveManager implements Manager
{
    private int $interval = 15; // secondes
    private int $lastSent = 0;

    public function tick(Server $server): void {
        $now = time();
        if ($now - $this->lastSent >= $this->interval) {
            $this->lastSent = $now;

            foreach ($server->getSessions() as $player) {
                $keepAliveId = $now; // ou uniqid(), ou random_int()

                $packet = new KeepAlivePacket($keepAliveId);
                $player->sendPacket($packet);

                $player->lastKeepAliveId = $keepAliveId;
            }
        }
    }
}