<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use stdClass;

class RegistryDataPacket extends Packet
{
    private string $registryId;
    private stdClass $entries;

    private static array $isDoubleTagField = [
        'offset',
        'tick_chance',
        'coordinate_scale',
    ];

    public function __construct(string $registryId, stdClass $entries)
    {
        $this->registryId = $registryId;
        $this->entries = $entries;
    }

    public function getId(): int
    {
        return 0x07;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        throw new \Exception("RegistryDataPacket ne peut pas être reçu");
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->registryId);

        $serializer->putVarInt(count((array) $this->entries));
        
        foreach ((array)$this->entries as $entryId => $data) {
            $serializer->putString($entryId);


            if (isset($data) && $data !== null) {
                $serializer->putBool(true);
                $serializer->putNBT((array)$data);
            } else {
                $serializer->putBool(false);
            }
        }
    }

    public function handle(Session $session): void
    {
        // Ce paquet est envoyé par le serveur, pas géré côté client
    }
}