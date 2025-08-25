<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;

class ChatMessagePacket extends ServerboundPacket
{
    /** @phpstan-ignore property.onlyWritten */
    private string $message;
    /** @phpstan-ignore property.onlyWritten */
    private int $timestamp; // milliseconds since epoch
    /** @phpstan-ignore property.onlyWritten */
    private int $salt;
    /** @phpstan-ignore property.onlyWritten */
    private ?string $signature = null; // 256 bytes when present
    /** @phpstan-ignore property.onlyWritten */
    private int $messageCount;
    /** @phpstan-ignore property.onlyWritten */
    private string $acknowledged; // fixed 20-bit bitset (stored as 3 raw bytes)
    /** @phpstan-ignore property.onlyWritten */
    private int $checksum;

    public function getId(): int
    {
        return 0x07;
    }

    public function read(PacketSerializer $serializer): void
    {
        // Message (max 256 chars per protocol, client enforces; we still read whatever is sent)
        $this->message = $serializer->getString();

        // Timestamp and salt
        $this->timestamp = $serializer->getLong();
        $this->salt = $serializer->getLong();

        // Signature: optional 256-byte array, not length-prefixed when present
        $hasSignature = $serializer->getBool();
        if ($hasSignature) {
            $this->signature = $serializer->getNBytes(256);
        } else {
            $this->signature = null;
        }

        // Message Count (VarInt)
        $this->messageCount = $serializer->getVarInt();

        // Acknowledged: Fixed BitSet (20) -> encoded as 20 bits; read 3 raw bytes
        $this->acknowledged = $serializer->getNBytes(3);

        // Checksum: single byte
        $this->checksum = $serializer->getByte();

        var_dump($this);
    }

    public function handle(Session $session): void
    {
        // Chat handling/broadcast can be implemented later. For now, parsing prevents disconnects.
    }
}

