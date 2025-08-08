<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Utils\BitSet;
use Nirbose\PhpMcServ\World\Chunk\HeightmapType;
use Nirbose\PhpMcServ\World\Palette;

class ChunkDataAndUpdateLightPacket extends ClientboundPacket
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

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putInt($this->chunkX) // Chunk X
            ->putInt($this->chunkZ); // Chunk Z

        $chunk = Artisan::getRegion()->getChunk($this->chunkX, $this->chunkZ);
        $heightmaps = $chunk->getHeightmaps();
        $serializer->putVarInt(count($heightmaps)); // Nombre de heightmaps

        foreach ($heightmaps as $key => $longArray) {
            $serializer->putVarInt(HeightmapType::of($key)->value)
                ->putVarInt(count($longArray));

            foreach ($longArray as $longValue) {
                $serializer->putLong($longValue);
            }
        }

        $dataBuf = new PacketSerializer('');
        $sections = $chunk->getSections();

        foreach ($sections as $key => $section) {
            /** @var Palette $palette */
            $palette = $section['palette'];

            if ($palette->getBlockCount() == 0) {
                $dataBuf->putShort(0)
                    ->putByte(0)
                    ->putVarInt(0)
                    ->putByte(0)
                    ->putVarInt(0);

                continue;
            }

            $data = $section['data'];

            $dataBuf->putShort($palette->getBlockCount()); // Calculate ALL block in the chunk (by data ? current is 3)

            $paletteSize = count($palette->getBlocks());
            $bitsPerBlock = max(4, (int)ceil(log($paletteSize, 2)));

            $dataBuf->putByte($bitsPerBlock)
                ->putVarInt($paletteSize);

            foreach ($palette->getBlocks() as $block) {
                $dataBuf->putVarInt($block);
            }

            foreach ($data as $long) {
                $dataBuf->putLong($long);
            }

            // Biomes
            $dataBuf->putByte(0)
                ->putVarInt(0);
        }

        $serializer->putVarInt(strlen($dataBuf->get()))
            ->put($dataBuf->get());

        $serializer->putVarInt(0);

        $skyLight = new BitSet(26);
        for ($i = 0; $i < 26; $i++) {
            $skyLight->set($i, true);
        }

        $serializer->putBitSet($skyLight)
            ->putVarInt(0)
            ->putVarInt(0)
            ->putVarInt(0)
            ->putVarInt(26);
        for ($i = 0; $i < 26; $i++) {
            $serializer->putVarInt(2048);
            for ($j = 0; $j < 2048; $j++) {
                $serializer->putByte(0xff);
            }
        }

        $serializer->putVarInt(0);
    }
}