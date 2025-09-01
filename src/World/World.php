<?php

namespace SnapMine\World;

use Error;
use SnapMine\Artisan;
use SnapMine\Entity\Entity;
use SnapMine\Entity\EntityType;
use SnapMine\Entity\Player;
use SnapMine\Network\Packet\Clientbound\Play\AddEntityPacket;
use SnapMine\Network\Packet\Clientbound\Play\RemoveEntitiesPacket;
use SnapMine\World\Chunk\Chunk;

class World
{
    /** @var array<string, Region> */
    private array $regions = [];
    private string $name;
    /** @var Entity[] */
    private array $entities = [];

    public function __construct(string $worldFolder)
    {
        $this->name = basename($worldFolder);

        foreach (glob($worldFolder . '/region/*.mca') as $file) {
            $this->regions[basename($file, '.mca')] = new Region($this, $file);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function hasChunk(int $x, int $z): bool
    {
        $regX = $x >> 5;
        $regZ = $z >> 5;
        $key = 'r.' . $regX . '.' . $regZ;

        if (isset($this->regions[$key])) {
            return $this->regions[$key]->hasChunk($x & 0x1F, $z & 0x1F);
        }
        return false;
    }

    public function getChunk(int $x, int $z): ?Chunk
    {
        $regX = $x >> 5;
        $regZ = $z >> 5;
        $key = 'r.' . $regX . '.' . $regZ;

        if (isset($this->regions[$key])) {
            $region = $this->regions[$key];

            return $region->getChunk($x & 0x1F, $z & 0x1F);
        }

        return null;
    }

    public function spawnEntity(EntityType $entityType, Location $location): Entity
    {
        $server = Artisan::getServer();
        $class = $entityType->getClass();
        /** @var Entity $entity */
        $entity = new $class($server, clone $location);

        $this->entities[$entity->getId()] = $entity;

        $server->broadcastPacket(new AddEntityPacket($entity, 0, 0, 0, 0));

        return $entity;
    }

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    public function getEntitiesByType(EntityType $entityType): array
    {
        $entities = [];

        foreach ($this->entities as $entity) {
            if ($entity->getType() === $entityType) {
                $entities[] = $entity;
            }
        }

        return $entities;
    }

    public function removeEntity(Entity $entity): void
    {
        if ($entity instanceof Player) {
            throw new Error("Cannot remove Player entity");
        }

        $this->removeEntityById($entity->getId());
    }

    public function removeEntityById(int $id): void
    {
        if (isset($this->entities[$id])) {
            unset($this->entities[$id]);

            Artisan::getServer()->broadcastPacket(new RemoveEntitiesPacket([$id]));
        }
    }

}