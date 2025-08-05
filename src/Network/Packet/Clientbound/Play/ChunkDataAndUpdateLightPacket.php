<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\BitSet;
use Nirbose\PhpMcServ\World\Chunk\HeightmapType;
use Nirbose\PhpMcServ\World\Palette;

class ChunkDataAndUpdateLightPacket extends Packet
{
    public function __construct(
        private readonly int $chunkX,
        private readonly int $chunkZ
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
        $sections = $chunk->getSections();

        foreach ($sections as $key => $section) {
            /** @var Palette $palette */
            $palette = $section['palette'];

            if ($palette->getBlockCount() == 0) {
                $dataBuf->putShort(0);

                $dataBuf->putByte(0);
                $dataBuf->putVarInt(0);

                $dataBuf->putByte(0);
                $dataBuf->putVarInt(0);

                continue;
            }

            $data = $section['data'];

            $dataBuf->putShort($palette->getBlockCount()); // Calculate ALL block in the chunk (by data ? current is 3)

            $paletteSize = count($palette->getBlocks());
            $bitsPerBlock = max(4, (int)ceil(log($paletteSize, 2)));

            $dataBuf->putByte($bitsPerBlock);
            $dataBuf->putVarInt($paletteSize);

//            var_dump($this->chunkX, $this->chunkZ, $palette->getBlocks());

            foreach ($palette->getBlocks() as $block) {
                $dataBuf->putVarInt($block);
            }

            foreach ($data as $long) {
                $dataBuf->putLong($long);
            }

            // Biomes
            $dataBuf->putByte(0);
            $dataBuf->putVarInt(0);
        }

        $s->putVarInt(strlen($dataBuf->get()));
        $s->put($dataBuf->get());

        $s->putVarInt(0);

        $skyLight = new BitSet(26);
        for ($i = 0; $i < 26; $i++) {
            $skyLight->set($i, true);
        }

        $s->putBitSet($skyLight);
        $s->putVarInt(0);
        $s->putVarInt(0);
        $s->putVarInt(0);

        $s->putVarInt(26);
        for ($i = 0; $i < 26; $i++) {
            $s->putVarInt(2048);
            for ($j = 0; $j < 2048; $j++) {
                $s->putByte(0xff);
            }
        }

        $s->putVarInt(0);
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void {}
    public function handle(Session $session): void {}
}