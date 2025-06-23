<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Aternos\Nbt\IO\Writer\StringWriter;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\LongArrayTag;
use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class ChunkDataAndUpdateLightPacket extends Packet
{
    public function getId(): int
    {
        return 0x27;
    }

    // public function write(PacketSerializer $serializer): void
    // {
    //     $chunkX = 0;
    //     $chunkZ = 0;
    //     $blockId = 1; // stone dans la registry data

    //     $serializer->putInt($chunkX);
    //     $serializer->putInt($chunkZ);

    //     // --- Heightmaps (MOTION_BLOCKING) ---
    //     $longs = array_fill(0, 256, 1);

    //     // Création du tag LongArray et remplissage via ArrayAccess
    //     $motionBlocking = new LongArrayTag();
    //     foreach ($longs as $i => $value) {
    //         $motionBlocking[$i] = $value;
    //     }

    //     // Création du CompoundTag contenant la heightmap
    //     $heightmap = new CompoundTag();
    //     $heightmap->set("MOTION_BLOCKING", $motionBlocking);

    //     // Écriture NBT au format Java
    //     $writer = (new StringWriter())->setFormat(NbtFormat::JAVA_EDITION);
    //     $heightmap->write($writer);

    //     // Récupération des données binaires
    //     $nbtData = $writer->getStringData();

    //     // Envoi au serializer
    //     $serializer->putVarInt(1);
    //     $serializer->put($nbtData);

    //     // --- Chunk data ---
    //     $dataBuffer = new PacketSerializer();

    //     // === Une seule section ===
    //     $dataBuffer->putShort(1); // 16*16*16 = 4096 stone
    //     $dataBuffer->putUnsignedByte(0);     // Bits Per Block = 0 (Single-valued palette)
    //     $dataBuffer->putVarInt($blockId); // Palette: ID = 1 (stone)
    //     $dataBuffer->putVarInt(0);   // Long array size = 0 (pas de data array nécessaire avec BPE=0)

    //     // --- Biomes ---
    //     $dataBuffer->putUnsignedByte(0);     // Bits per biome = 0 (single-valued)
    //     $dataBuffer->putVarInt(127); // Biome ID (void)
    //     $dataBuffer->putVarInt(0);   // Long array size = 0 (pas de data array nécessaire avec BPE=0)

    //     // --- Fin de la section ---

    //     $serializer->putVarInt(strlen($dataBuffer->get()));
    //     $serializer->put($dataBuffer->get());

    //     // --- Block Entities ---
    //     $serializer->putVarInt(0); // Aucun

    //     // --- Light Data ---
    //     // $serializer->putByte(0b00010000); // Trust Edges = true, Skylight Mask = 0, Blocklight Mask = 0b0001 0000
    //     $serializer->putVarInt(0); // Empty Sky Light mask count
    //     $serializer->putVarInt(0); // Empty Block Light mask count
    //     $serializer->putVarInt(0); // Sky Light data count
    //     $serializer->putVarInt(0); // Block Light data count
    //     $serializer->putVarInt(0); // Empty Sky Light data count
    //     $serializer->putVarInt(0); // Empty Block Light data count

    //     // Maintenant, envelopper dans un paquet ID 0x27 et l’envoyer au client

    // }

    // public function write(PacketSerializer $s): void {
    //     // --- Coordonnées chunk ---
    //     $s->putInt(0);
    //     $s->putInt(0);
    //     // --- Heightmap MOTION_BLOCKING ---
    //     $heights = array_fill(0, 256, 65); // y=65 solide
    //     $bitCount = ceil(log(384 + 1, 2)); // 9 bits
    //     $longValues = [];

    //     // Encode 256 entrées de 9 bits dans 36 longs
    //     $bits = '';
    //     foreach ($heights as $h) {
    //         $bits .= str_pad(decbin($h), 9, '0', STR_PAD_LEFT);
    //     }
    //     for ($i = 0; $i < 36; $i++) {
    //         $chunkBits = substr($bits, $i * 64, 64);
    //         $longValues[] = (int)(str_pad($chunkBits, 64, '0', STR_PAD_RIGHT));
    //     }

    //     // $lat = new LongArrayTag();
    //     // foreach ($longValues as $i => $v) {
    //     //     $lat[$i] = $v;
    //     // }
    //     // $nbt = new CompoundTag();
    //     // $nbt->set(null, $lat);
    //     // $writer = (new StringWriter())->setFormat(NbtFormat::JAVA_EDITION);
    //     // $nbt->write($writer);
    //     // $nbtData = $writer->getStringData();

    //     $s->putVarInt(1);  // nombre de heightmaps
    //     // $s->put($nbtData);
    //     $s->putVarInt(1);  // MOTION_BLOCKING
    //     var_dump(count($longValues));
    //     $s->putVarInt(count($longValues)); // nombre de longs
    //     foreach ($longValues as $value) {
    //         $s->putLong($value);
    //     }

    //     // --- Chunk Data (une seule section stone) ---
    //     $dataBuf = new PacketSerializer();
    //     $dataBuf->putInt(1);        // nombre de sections
    //     // $dataBuf->putInt(1 << 4);   // mask sections, ici 1ère section
    //     // Pour chaque section...
    //     $dataBuf->putShort(4096);  // block count
    //     $dataBuf->putByte(0);       // BitsPerBlock = 0 (single palette)
    //     $dataBuf->putVarInt(4);     // ID vanilla stone
    //     // $dataBuf->putVarInt(0);     // pas de long-array
    //     // $dataBuf->putLong(0);
    //     // $dataBuf->putLong(0);
    //     // $dataBuf->putLong(0);
    //     // Biome
    //     $dataBuf->putByte(0);       // BitsPerBiome
    //     $dataBuf->putVarInt(127);   // biome void
    //     // $dataBuf->putLong(0);
    //     // $dataBuf->putLong(0);
    //     // $dataBuf->putLong(0);

    //     $bytes = $dataBuf->get();
    //     $s->putVarInt(strlen($bytes));
    //     $s->put($bytes);

    //     // --- Pas de BlockEntities ---
    //     $s->putVarInt(0);

    //     // --- Light Data (vide) ---
    //     $s->putBool(true);         // trust edges
    //     $s->putVarInt(0);          // skyMask count
    //     $s->putVarInt(0);          // blockMask count
    //     $s->putVarInt(0);          // emptySkyMask
    //     $s->putVarInt(0);          // emptyBlockMask
    //     $s->putVarInt(0);          // skyLight data
    //     $s->putVarInt(0);          // blockLight data
    // }

    public function write(PacketSerializer $s): void
    {
        $s->putInt(0); // Chunk X
        $s->putInt(0); // Chunk Z

        $s->putVarInt(0); // Nombre de heightmaps
        $dataBuf = new PacketSerializer();

        for ($i = 0; $i < 24; $i++) {
            $dataBuf->putShort(4096);
            $dataBuf->putByte(0);
            $dataBuf->putVarInt(10);

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