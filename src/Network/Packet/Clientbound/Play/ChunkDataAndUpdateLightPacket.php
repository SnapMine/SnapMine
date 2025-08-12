<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Utils\BitSet;
use Nirbose\PhpMcServ\World\Chunk\HeightmapType;
use Nirbose\PhpMcServ\World\PalettedContainer;

class ChunkDataAndUpdateLightPacket extends ClientboundPacket
{
    public function __construct(
        private readonly int $chunkX,
        private readonly int $chunkZ
    )
    {
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

        $serializer->putVarInt(count($heightmaps));
        foreach ($heightmaps as $key => $longArray) {
            $serializer->putVarInt(HeightmapType::of($key)->value)
                ->putVarInt(count($longArray));

            foreach ($longArray as $longValue) {
                $serializer->putLong($longValue);
            }
        }

        $dataBuf = new PacketSerializer('');
        $sections = $chunk->getSections();

        for ($i = 0; $i < 24; $i++) {

            if (!isset($sections[$i - 5])) {
                $dataBuf->putShort(0)
                    ->putByte(0)
                    ->putVarInt(0)
                    ->putByte(0)
                    ->putVarInt(0);

                continue;
            }

            $section = $sections[$i - 5];

            /** @var PalettedContainer $palette */
            $palette = $section['palette'];
            $totalBlock = $section['totalBlock'];

            if ($totalBlock == 0) {
                $dataBuf->putShort(0)
                    ->putByte(0)
                    ->putVarInt(0)
                    ->putByte(0)
                    ->putVarInt(0);

                continue;
            }

            $data = $section['data'];

            $dataBuf->putShort($totalBlock);

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

        $serializer->putVarInt(0); // Block entities

        $skyLightMask = new BitSet(24);
        $blockLightMask = new BitSet(24);
        $emptySkyLightMask = new BitSet(24);
        $emptyBlockLightMask = new BitSet(24);
        $skyLightData = [];
        $blockLightData = [];

        $sections = $chunk->getSections();
        foreach ($sections as $y => $section) {
            $hasSkyLight = !empty($section['skyLight']);
            $hasBlockLight = !empty($section['blockLight']);

            if ($hasSkyLight) {
                $skyLightMask->set($y + 5, true);
                $skyLightData[] = $section['skyLight'];
            }
            if ($hasBlockLight) {
                $blockLightMask->set($y + 5, true);
                $blockLightData[] = $section['blockLight'];
            }

            if (!$hasSkyLight) {
                $emptySkyLightMask->set($y + 5, true);
            }
            if (!$hasBlockLight) {
                $emptyBlockLightMask->set($y + 5, true);
            }
        }

        $serializer->putBitSet($skyLightMask)
            ->putBitSet($blockLightMask)
            ->putBitSet($emptySkyLightMask)
            ->putBitSet($emptyBlockLightMask)
            ->putVarInt(count($skyLightData));
        foreach ($skyLightData as $data) {
            $serializer->putByteArray($data);
        }

        $serializer->putVarInt(count($blockLightData));
        foreach ($blockLightData as $data) {
            $serializer->putByteArray($data);
        }
    }
}