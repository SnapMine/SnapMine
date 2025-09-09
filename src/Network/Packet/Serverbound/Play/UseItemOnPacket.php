<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Block\Data\Interactable;
use SnapMine\Block\Direction;
use SnapMine\Inventory\ItemStack;
use SnapMine\Inventory\PlayerInventory;
use SnapMine\Material;
use SnapMine\Network\Packet\Clientbound\Play\BlockChangedAckPacket;
use SnapMine\Inventory\InventoryType;
use SnapMine\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\World\Position;
use SnapMine\Network\Packet\Clientbound\Play\OpenScreenPacket;
use SnapMine\Component\TextComponent;

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
        $direction = Direction::cases()[$this->face];

        $block = $server
            ->getWorld("world")
            ->getChunk(((int)$this->position->getX()) >> 4, ((int)$this->position->getZ()) >> 4)
            ->getBlock($this->position);

        $blockData = $block->getBlockData();

        if ($blockData instanceof Interactable) {
            if (!$session->getPlayer()->isSneaking()) {
                $interactionHappened = $blockData->interact($session->getPlayer(), $block);
                if ($interactionHappened) return;
            }
        }


        $loc = $block->getLocation()->addDirection($direction);
        $b = $server->getWorld('world')->getBlock($loc);

        if ($b->isSolid()) return;

        $index = $session->getPlayer()->getInventory()->getHeldHotbarSlot() + 36;

        if ($this->hand === 1) $index = PlayerInventory::OFF_HAND_SLOT;

        $item = $session->getPlayer()->getInventory()->getItem($index);


        if (!$item->getMaterial()->isBlock() || $item->getMaterial()->isAir() || $item->getAmount() < 1) return;
        $item->setAmount($item->getAmount() - 1);
        $session->getPlayer()->getInventory()->setItem($index, $item);

        $b->setMaterial($item->getMaterial());

        $server->broadcastPacket(new BlockChangedAckPacket($this->sequence));
        $server->broadcastPacket(new BlockUpdatePacket($this->position, $block));

        $blockData = $block->getMaterial()->getKey();
        $player = $session->getPlayer();
        

        $blockList = [
            Material ::TRAPPED_CHEST->getKey() => [InventoryType::GENERIC_9X3,'Trapped Chest'],
            Material ::ENDER_CHEST->getKey() => [InventoryType::GENERIC_9X3,'Ender Chest'],
            Material ::BARREL->getKey() => [InventoryType::GENERIC_9X3,'Barrel'],
            Material ::DISPENSER->getKey() => [InventoryType::GENERIC_3X3, 'Dispenser'],
            Material ::DROPPER->getKey() => [InventoryType::GENERIC_3X3,'Dropper'],
            Material ::CRAFTER->getKey() => [InventoryType::CRAFTER_3X3, 'Crafter'],
            Material ::ANVIL->getKey() => [InventoryType::ANVIL, 'Anvil'],
            Material ::BEACON->getKey() => [InventoryType::BEACON, 'Beacon'],
            Material ::BLAST_FURNACE->getKey() => [InventoryType::BLAST_FURNACE, 'Blast Furnace'],
            Material ::BREWING_STAND->getKey() => [InventoryType::BREWING_STAND, 'Brewing Stand'],
            Material ::CRAFTING_TABLE->getKey() => [InventoryType::CRAFTING, 'Crafting Table'],
            Material ::ENCHANTING_TABLE->getKey() => [InventoryType::ENCHANTING, 'Enchanting Table'],
            Material ::FURNACE->getKey() => [InventoryType::FURNACE, 'Furnace'],
            Material ::GRINDSTONE->getKey() => [InventoryType::GRINDSTONE, 'Grindstone'],
            Material ::HOPPER->getKey() => [InventoryType::HOPPER, 'Hopper'],
            Material ::HOPPER_MINECART->getKey() => [InventoryType::HOPPER, 'Minecart with Hopper'],
            Material ::LECTERN->getKey() => [InventoryType::LECTERN, 'Lectern'],
            Material ::LOOM->getKey() => [InventoryType::LOOM, 'Loom'],
            Material ::SHULKER_BOX->getKey() => [InventoryType::SHULKER_BOX, 'Shulker Box'],
            Material ::SMITHING_TABLE->getKey() => [InventoryType::SMITHING, 'Smithing Table'],
            Material ::SMOKER->getKey() => [InventoryType::SMOKER, 'Smoker'],
            Material ::CARTOGRAPHY_TABLE->getKey() => [InventoryType::CARTOGRAPHY_TABLE, 'Cartography Table'],
            Material ::STONECUTTER->getKey() => [InventoryType::STONECUTTER, 'Stonecutter'],
        ];

        if (isset($blockList[$blockData])) {
            [$windowType, $windowTitle] = $blockList[$blockData];

            $player->sendPacket(new OpenScreenPacket(1, $windowType, TextComponent::text($windowTitle)));
        } 
    }
}