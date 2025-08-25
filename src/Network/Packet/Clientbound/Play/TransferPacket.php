<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

class TransferPacket extends \SnapMine\Network\Packet\Clientbound\Configuration\TransferPacket
{
    public function getId(): int
    {
        return 0x7A;
    }
}