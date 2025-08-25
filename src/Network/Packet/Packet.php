<?php

namespace SnapMine\Network\Packet;

use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

interface Packet
{

    public function getId(): int;

    public function handle(Session $session): void;
}