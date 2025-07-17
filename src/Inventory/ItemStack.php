<?php

namespace Nirbose\PhpMcServ\Inventory;

class ItemStack
{
    private int $id; // TODO: Replace by Material enum
    private int $amount;
    private array $components = [];

    public function __construct(int $id, int $amount)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
}