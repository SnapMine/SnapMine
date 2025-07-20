<?php

namespace Nirbose\PhpMcServ\Inventory;

use Nirbose\PhpMcServ\Component\DataComponentType;
use Nirbose\PhpMcServ\Material;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

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

    public static function decode(string $buffer): ItemStack
    {
        $offset = 0;
        $s = new PacketSerializer();

        $amount = $s->getVarInt($buffer, $offset);
        $id = $s->getVarInt($buffer, $offset);
        $item = new self(Material::cases()[$id], $amount);

        $numberComponentsAdded = $s->getVarInt($buffer, $offset);
        $numberComponentsRemoved = $s->getVarInt($buffer, $offset);

        for ($i = 0; $i < $numberComponentsAdded; $i++) {
            $index = $s->getVarInt($buffer, $offset);

            $class = DataComponentType::cases()[$index]->handlerClass();

            if (is_null($class)) {
                continue;
            }

            if (enum_exists($class)) {
                $s->getVarInt($buffer, $offset);
            } else {
                // TODO: DECODE
            }
        }

        return $item;
    }
}