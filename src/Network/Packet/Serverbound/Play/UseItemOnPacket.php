<?php

namespace SnapMine\Network\Packet\Serverbound\Play;

use SnapMine\Block\Data\Interactable;
use SnapMine\Block\Direction;
use SnapMine\Inventory\Inventory;
use SnapMine\Inventory\PlayerInventory;
use SnapMine\Material;
use SnapMine\Network\Packet\Clientbound\Play\BlockChangedAckPacket;
use SnapMine\Inventory\InventoryType;
use SnapMine\Network\Packet\Clientbound\Play\BlockUpdatePacket;
use SnapMine\Network\Packet\Serverbound\ServerboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Session\Session;
use SnapMine\World\Position;
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

        $blockInv =  match ($block->getMaterial()) {
            Material::BARREL => [InventoryType::GENERIC_9X3, 'Barrel'],
            Material::DISPENSER => [InventoryType::GENERIC_3X3, 'Dispenser'],
            Material::DROPPER => [InventoryType::GENERIC_3X3, 'Dropper'],
            Material::ANVIL => [InventoryType::ANVIL, 'Anvil'],
            Material::BEACON => [InventoryType::BEACON, 'Beacon'],
            Material::BREWING_STAND => [InventoryType::BREWING_STAND, 'Brewing Stand'],
            Material::CRAFTING_TABLE => [InventoryType::CRAFTING, 'Crafting Table'],
            Material::ENCHANTING_TABLE => [InventoryType::ENCHANTING, 'Enchanting Table'],
            Material::GRINDSTONE => [InventoryType::GRINDSTONE, 'Grindstone'],
            Material::HOPPER => [InventoryType::HOPPER, 'Hopper'],
            Material::LECTERN => [InventoryType::LECTERN, 'Lectern'],
            Material::LOOM => [InventoryType::LOOM, 'Loom'],
            Material::SHULKER_BOX => [InventoryType::SHULKER_BOX, 'Shulker Box'],
            Material::SMITHING_TABLE => [InventoryType::SMITHING, 'Smithing Table'],
            Material::SMOKER => [InventoryType::SMOKER, 'Smoker'],
            Material::CARTOGRAPHY_TABLE => [InventoryType::CARTOGRAPHY_TABLE, 'Cartography Table'],
            Material::STONECUTTER => [InventoryType::STONECUTTER, 'Stonecutter'],
            default => null,
        };

        if (is_array($blockInv)) {
            [$windowType, $windowTitle] = $blockInv;

            $session->getPlayer()->openInventory(new Inventory($windowType, TextComponent::text($windowTitle)));
            return;
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
    }
}