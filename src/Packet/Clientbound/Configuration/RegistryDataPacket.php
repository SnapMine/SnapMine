<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Configuration;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class RegistryDataPacket extends Packet
{
    private string $registryId;
    private array $entries;

    private static array $isDoubleTagField = [
        'offset',
        'tick_chance',
        'coordinate_scale',
    ];

    public function __construct(string $registryId, array $entries)
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

        $serializer->putVarInt(count($this->entries));
        
        foreach ($this->entries as $id => $entry) {
            $serializer->putNBTString($id);

            if (isset($entry) && $entry !== null) {
                $serializer->putBool(true);
                $serializer->putNBT($entry, type: in_array($id, self::$isDoubleTagField) ? 6 : null);
            } else {
                $serializer->putBool(false); // No data
            }
        }
    }

    public function handle(Session $session): void
    {
        // Ce paquet est envoyé par le serveur, pas géré côté client
    }

    // Méthodes statiques pour créer les différents types de registres

    public static function createRegistryDataPacket(string $registryId, array $entries): self
    {
        return new self($registryId, $entries);
    }
}