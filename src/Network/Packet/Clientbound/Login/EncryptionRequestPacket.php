<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Login;

use Nirbose\PhpMcServ\Extras\Auth\MojangAuth;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\Random;

class EncryptionRequestPacket extends Packet {
    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString("");

        $publicKey = MojangAuth::getPublicKey();

        $serializer->putString($publicKey);
        $serializer->putString(Random::str(4));
        $serializer->putBool(true);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
    }
    
    public function handle(Session $session): void
    {
    }
}