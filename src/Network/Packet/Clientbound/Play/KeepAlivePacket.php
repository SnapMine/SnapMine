<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class KeepAlivePacket extends Packet {

    private int $keepAliveId;

    public function __construct(int $keepAliveId = 0) {
        $this->keepAliveId = $keepAliveId;
    }

    public function getId(): int {
        return 0x26;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putLong($this->keepAliveId);
    }

    public function handle(Session $session): void
    {
        
    }
}