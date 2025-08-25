<?php

namespace SnapMine\Inventory;

use SnapMine\Component\DataComponentType;
use SnapMine\Material;
use SnapMine\Network\Serializer\PacketSerializer;

class ItemStack
{
    private array $components = [];

    public function __construct(
        private Material $material,
        private int $amount
    ) {
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
     * @throws \Exception
     */
    public static function decode(PacketSerializer $in): ItemStack
    {

        $amount = $in->getVarInt();
        $id = $in->getVarInt();
        $item = new self(Material::getMaterial($id), $amount);

        $numberComponentsAdded = $in->getVarInt();
        $numberComponentsRemoved = $in->getVarInt();

        for ($i = 0; $i < $numberComponentsAdded; $i++) {
            $index = $in->getVarInt();

            $class = DataComponentType::cases()[$index]->handlerClass();

            if (is_null($class)) {
                continue;
            }

            if (enum_exists($class)) {
                $in->getVarInt();
            } else {
                // TODO: DECODE
            }
        }

        return $item;
    }
}