<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\World\HeightmapType;

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
//        $s->putInt($this->chunkX); // Chunk X
//        $s->putInt($this->chunkZ); // Chunk Z
        $s->putInt(0); // Chunk X
        $s->putInt(0); // Chunk Z

        $chunk = Artisan::getRegion()->getChunk($this->chunkX, $this->chunkZ);
        $heightmaps = $chunk->getHeightmaps();
        $s->putVarInt(count($heightmaps)); // Nombre de heightmaps

        foreach ($heightmaps as $key => $longArray) {
            $s->putVarInt(HeightmapType::of($key)->value);
            $s->putVarInt(count($longArray));

            foreach ($longArray as $longValue) {
                $s->putLong($longValue);
            }
        }

        $dataBuf = new PacketSerializer();

        for ($i = 0; $i < 24; $i++) {
            $dataBuf->putShort($chunk->getPalette()->getBlockCount());

             $dataBuf->putByte(4);
             $dataBuf->putVarInt(count($chunk->getPalette()->getBlocks()));
             foreach ($chunk->getPalette()->getBlocks() as $block) {
                 $dataBuf->putVarInt($block);
             }
             foreach ($chunk->getData() as $data) {
                 $dataBuf->putLong($data);
             }

             $dataBuf->putByte(0);
             $dataBuf->putVarInt(0);
        }

//        $s->putVarInt(0);
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