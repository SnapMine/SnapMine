<?php

namespace SnapMine\Inventory;

use SnapMine\Component\DataComponentType;
use SnapMine\Material;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolDecodable;
use SnapMine\Network\Serializer\ProtocolEncodable;

class ItemStack implements ProtocolDecodable, ProtocolEncodable
{
    private array $components = [];

    public function __construct(
        private Material $material,
        private int      $amount
    )
    {
    }

    /**
     * @return Material
     */
    public function getMaterial(): Material
    {
        return $this->material;
    }

    /**
     * @param Material $material
     */
    public function setMaterial(Material $material): void
    {
        $this->material = $material;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Set max stack size of this item
     *
     * @param int $size
     * @return void
     */
    public function setMaxStackSize(int $size): void
    {
        if ($size < 1 || $size > 99) {
            $size = max(1, min($size, 99));
        }

        $this->components[1] = $size;
    }

    /**
     * Get max stack size of this item
     *
     * @return int
     */
    public function getMaxStackSize(): int
    {
        return $this->components[1];
    }

    /**
     * @param PacketSerializer $serializer
     * @return ItemStack
     * @throws \Exception
     */
    public static function decode(PacketSerializer $serializer): ItemStack
    {

        $amount = $serializer->getVarInt();
        $id = $serializer->getVarInt();
        $item = new self(Material::getMaterial($id), $amount);

        $numberComponentsAdded = $serializer->getVarInt();
        $numberComponentsRemoved = $serializer->getVarInt();

        for ($i = 0; $i < $numberComponentsAdded; $i++) {
            $index = $serializer->getVarInt();

            $class = DataComponentType::cases()[$index]->handlerClass();

            if (is_null($class)) {
                continue;
            }

            if (enum_exists($class)) {
                $serializer->getVarInt();
            } else {
                // TODO: DECODE
            }
        }

        return $item;
    }

    public function encode(PacketSerializer $serializer): void
    {
        $serializer->putVarInt($this->amount);

        if ($this->amount > 0) {
            $serializer
                ->putVarInt($this->material->getItemId())
                ->putVarInt(0)
                ->putVarInt(0);
        }
    }

    public static function empty(): ItemStack
    {
        return new ItemStack(Material::AIR, 0);
    }
}