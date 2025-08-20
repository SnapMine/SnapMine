<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

class TransferPacket extends \Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration\TransferPacket
{
    public function getId(): int
    {
        return 0x7A;
    }
}