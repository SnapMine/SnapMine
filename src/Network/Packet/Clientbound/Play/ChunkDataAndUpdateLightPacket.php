<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Artisan;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Utils\BitSet;
use Nirbose\PhpMcServ\World\Chunk\ChunkSection;
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
            $sectionY = $i - 5;

            if (!isset($sections[$sectionY])) {
                $dataBuf->putShort(0)
                    ->putByte(0)
                    ->putVarInt(0)
                    ->putByte(0)
                    ->putVarInt(0);

                continue;
            }

            $section = $sections[$sectionY];

            $blockCount = $section->getBlockCount();

            if ($blockCount == 0) {
                $dataBuf->putShort(0)
                    ->putByte(0)
                    ->putVarInt(0)
                    ->putByte(0)
                    ->putVarInt(0);

                continue;
            }

            $palettedContainer = $section->getPalettedContainer();
            $palette = $palettedContainer->getPalette();
            $data = $palettedContainer->getData();

            $dataBuf->putShort($blockCount);

            $paletteSize = count($palette);
            $bitsPerBlock = max(4, (int)ceil(log($paletteSize, 2)));

            $dataBuf->putByte($bitsPerBlock)
                ->putVarInt($paletteSize);

            foreach ($palette as $blockData) {
                $blockId = $blockData->computedId(Artisan::getBlockStateLoader());
                $dataBuf->putVarInt($blockId);
            }

            $dataBuf->putVarInt(count($data));
            foreach ($data as $long) {
                $dataBuf->putLong($long);
            }

            // Biomes
            $dataBuf->putByte(0)
                ->putVarInt(0);
        }

        $serializer->putVarInt(strlen($dataBuf->get()))
            ->put($dataBuf->get());

        $serializer->putVarInt(count($chunk->getBlockEntities())); // Block entities

        $skyLightMask = new BitSet(24);
        $blockLightMask = new BitSet(24);
        $emptySkyLightMask = new BitSet(24);
        $emptyBlockLightMask = new BitSet(24);
        $skyLightData = [];
        $blockLightData = [];

        $sections = $chunk->getSections();
        foreach ($sections as $y => $section) {
            $hasSkyLight = !empty($section->getSkyLight());
            $hasBlockLight = !empty($section->getBlockLight());

            if ($hasSkyLight) {
                $skyLightMask->set($y + 5, true);
                $skyLightData[] = $section->getSkyLight();
            }
            if ($hasBlockLight) {
                $blockLightMask->set($y + 5, true);
                $blockLightData[] = $section->getBlockLight();
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