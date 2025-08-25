<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\BitSet;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\Chunk\HeightmapType;

class ChunkDataAndUpdateLightPacket extends ClientboundPacket
{
    public function __construct(
        private readonly Chunk $chunk,
    )
    {
    }

    public function getId(): int
    {
        return 0x27;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putInt($this->chunk->getX()) // Chunk X
        ->putInt($this->chunk->getZ()); // Chunk Z

        $chunk = $this->chunk;
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

        for ($i = -4; $i < 20; $i++) {
            $sectionY = $i;

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

            if ($section->isEmpty()) {
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
                $blockId = $blockData->computedId();
                $dataBuf->putVarInt($blockId);
            }

            //$dataBuf->putVarInt(count($data));
            foreach ($data as $long) {
                $dataBuf->putLong($long);
            }

            // Biomes
            $dataBuf->putByte(0)
                ->putVarInt(0);
        }

        $serializer->putVarInt(strlen($dataBuf->get()))
            ->put($dataBuf->get());

        //$serializer->putVarInt(count($chunk->getBlockEntities())); // Block entities
        $serializer->putVarInt(0);

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

        //echo "Content packet: " . bin2hex($serializer->get()) . "\n";
    }
}