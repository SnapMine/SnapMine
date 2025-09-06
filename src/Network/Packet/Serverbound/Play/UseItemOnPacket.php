<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\World\Position;
use SnapMine\Network\Packet\Clientbound\Play\OpenScreenPacket;
use SnapMine\Component\TextComponent;
use SnapMine\Material;

class UseItemOnPacket extends ServerboundPacket
{
    private int $hand;
    private Position $position;
    private int $face;
    private float $cursorPositionX;
    private float $cursorPositionY;
    private float $cursorPositionZ;
    private bool $insideBlock;
    private bool $worldBorderHit;
    private int $sequence;

    public function getId(): int
    {
        return 0x3E;
    }

    public function read(PacketSerializer $serializer): void
    {
        $this->hand = $serializer->getVarInt();
        $this->position = $serializer->getPosition();
        $this->face = $serializer->getVarInt();
        $this->cursorPositionX = $serializer->getFloat();
        $this->cursorPositionY = $serializer->getFloat();
        $this->cursorPositionZ = $serializer->getFloat();
        $this->insideBlock = $serializer->getBool();
        $this->worldBorderHit = $serializer->getBool();
        $this->sequence = $serializer->getVarInt();
    }

    public function handle(Session $session): void
    {
        $server = $session->getServer();
        $block = $server
            ->getWorld("world")
            ->getChunk(((int)$this->position->getX()) >> 4, ((int)$this->position->getZ()) >> 4)
            ->getBlock($this->position);

        $server->broadcastPacket(new BlockUpdatePacket($this->position, $block));

        $blockData = $block->getMaterial()->getKey();
        $player = $session->getPlayer();
        
        $chestBoats =[
            Material::OAK_CHEST_BOAT->getKey(),
            Material::BIRCH_CHEST_BOAT->getKey(),
            Material::DARK_OAK_CHEST_BOAT->getKey(),
            Material::ACACIA_CHEST_BOAT->getKey(),
            Material::BAMBOO_CHEST_RAFT->getKey(),
            Material::JUNGLE_CHEST_BOAT->getKey(),
            Material::SPRUCE_CHEST_BOAT->getKey(),
            Material::MANGROVE_CHEST_BOAT->getKey(),
            Material::PALE_OAK_CHEST_BOAT->getKey(),
        ];

        $blockList = [
            Material ::CHEST_MINECART->getKey() => [2, 'Minecart with Chest'],
            Material ::CHEST->getKey() => [2,'Chest'],
            Material ::TRAPPED_CHEST->getKey() => [2,'Trapped Chest'],
            Material ::ENDER_CHEST->getKey() => [2,'Ender Chest'],
            Material ::BARREL->getKey() => [2,'Barrel'],
            Material ::DISPENSER->getKey() => [6, 'Dispenser'],
            Material ::DROPPER->getKey() => [6,'Dropper'],
            Material ::CRAFTER->getKey() => [7, 'Crafter'],
            Material ::ANVIL->getKey() => [8, 'Anvil'],
            Material ::BEACON->getKey() => [9, 'Beacon'],
            Material ::BLAST_FURNACE->getKey() => [10, 'Blast Furnace'],
            Material ::BREWING_STAND->getKey() => [11, 'Brewing Stand'],
            Material ::CRAFTING_TABLE->getKey() => [12, 'Crafting Table'],
            Material ::ENCHANTING_TABLE->getKey() => [13, 'Enchanting Table'],
            Material ::FURNACE->getKey() => [14, 'Furnace'],
            Material ::GRINDSTONE->getKey() => [15, 'Grindstone'],
            Material ::HOPPER->getKey() => [16, 'Hopper'],
            Material ::HOPPER_MINECART->getKey() => [16, 'Minecart with Hopper'],
            Material ::LECTERN->getKey() => [17, 'Lectern'],
            Material ::LOOM->getKey() => [18, 'Loom'],
            Material ::SHULKER_BOX->getKey() => [20, 'Shulker Box'],
            Material ::SMITHING_TABLE->getKey() => [21, 'Smithing Table'],
            Material ::SMOKER->getKey() => [22, 'Smoker'],
            Material ::CARTOGRAPHY_TABLE->getKey() => [23, 'Cartography Table'],
            Material ::STONECUTTER->getKey() => [24, 'Stonecutter'],
        ];

        foreach ($chestBoats as $boatMaterial) {
            $blockList[$boatMaterial] = [2, 'Boat with Chest'];
        }

        if (isset($blockList[$blockData])) {
            [$windowType, $windowTitle] = $blockList[$blockData];

            $player->sendPacket(new OpenScreenPacket(1, $windowType, TextComponent::text($windowTitle)));
        } 
    }
}