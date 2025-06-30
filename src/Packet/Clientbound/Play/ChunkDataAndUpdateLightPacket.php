<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ChunkDataAndUpdateLightPacket extends Packet
{
    public function __construct(
        private int $chunkX,
        private int $chunkZ
    ) {  
    }

    public function getId(): int
    {
        return 0x27;
    }

    public function write(PacketSerializer $s): void
    {
        $s->putInt($this->chunkX); // Chunk X
        $s->putInt($this->chunkZ); // Chunk Z

        $s->putVarInt(0); // Nombre de heightmaps

        $dataBuf = new PacketSerializer();

        for ($i = 0; $i < 24; $i++) {
            $dataBuf->putShort(1);
//            $dataBuf->putByte(15);
//
//            $entry1 = 1;
//            $entry2 = 1;
//
//            $long = 0;
//            $long |= $entry1 << 15;     // bloc 1
//            $long |= $entry2 << 30;    // bloc 2
//            $long |= $entry1 << 45;    // bloc 3
//            $long |= $entry2 << 60;    // bloc 4
//            $long |= $entry2 << 60;    // bloc 5
//
//            for ($j = 0; $j < 1024; $j++) {
//                $dataBuf->putLong($long);
//            }
             $dataBuf->putByte(0);
             $dataBuf->putVarInt(1);

             $dataBuf->putByte(0);
             $dataBuf->putVarInt(0);
        }

        $s->putVarInt(strlen($dataBuf->get()));
        $s->put($dataBuf->get());

        $s->putVarInt(0);
        
        $s->putVarInt(0);
        $s->putVarInt(0);
        $s->putVarInt(0);
        $s->putVarInt(0);
        $s->putVarInt(0);
        $s->putVarInt(0);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void {}
    public function handle(Session $session): void {}
}