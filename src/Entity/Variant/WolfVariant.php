<?php

namespace SnapMine\Entity\Variant;

use SnapMine\Nbt\NbtCompound;
use SnapMine\Nbt\NbtList;
use SnapMine\NbtSerializable;
use SnapMine\Registry\RegistryData;

/**
 * @method static WolfVariant ASHEN()
 * @method static WolfVariant BLACK()
 * @method static WolfVariant CHESTNUT()
 * @method static WolfVariant PALE()
 * @method static WolfVariant RUSTY()
 * @method static WolfVariant SNOWY()
 * @method static WolfVariant SPOTTED()
 * @method static WolfVariant STRIPED()
 * @method static WolfVariant WOODS()
 */
class WolfVariant extends RegistryData implements NbtSerializable
{
    #[NbtCompound('assets')]
    private WolfAssets $assets;

    #[NbtList('spawn_conditions', SpawnConditions::class, true)]
    private array $spawnConditions = [];

    /**
     * @return WolfAssets
     */
    public function getAssets(): WolfAssets
    {
        return $this->assets;
    }

    /**
     * @return array
     */
    public function getSpawnConditions(): array
    {
        return $this->spawnConditions;
    }
}