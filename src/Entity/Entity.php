<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Component\TextComponent;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Location;

abstract class Entity
{
    protected int $internalId;
    protected UUID $uuid;
    protected PacketSerializer $buffer;
    private int $state = 0;
    private ?TextComponent $customName = null;
    private bool $customNameVisible = false;
    private bool $silent = false;
    private bool $gravity = false;
    private Pose $pose = Pose::STANDING;

    public function __construct(
        protected Server   $server,
        protected Location $location,
    )
    {
        $this->internalId = $this->server->incrementAndGetId();
        $this->uuid = UUID::generate();
        $this->buffer = new PacketSerializer();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->internalId;
    }

    /**
     * Get entity uuid
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    public function isOnFire(): bool
    {
        return $this->state & 0x01;
    }

    public function setOnFire(bool $state): void
    {
        $this->setState(0x01, $state);
    }

    public function isSneaking(): bool
    {
        return $this->state & 0x02;
    }

    public function setSneaking(bool $state): void
    {
        $this->setState(0x02, $state);
    }

    public function isSprinting(): bool
    {
        return $this->state & 0x08;
    }

    public function setSprinting(bool $state): void
    {
        $this->setState(0x08, $state);
    }

    public function isSwimming(): bool
    {
        return $this->state & 0x10;
    }

    public function setSwimming(bool $state): void
    {
        $this->setState(0x10, $state);
    }

    public function isInvisible(): bool
    {
        return $this->state & 0x20;
    }

    public function setInvisible(bool $state): void
    {
        $this->setState(0x20, $state);
    }

    public function isGlowing(): bool
    {
        return $this->state & 0x40;
    }

    public function setGlowing(bool $state): void
    {
        $this->setState(0x40, $state);
    }

    private function setState(int $bit, bool $set): void
    {
        if ($set) {
            $this->state |= $bit;
        } else {
            $this->state &= ~$bit;
        }
    }

    public function setCustomName(TextComponent|string $customName): void
    {
        if (is_string($customName)) {
            $customName = TextComponent::text($customName);
        }

        $this->customName = $customName;
    }

    public function getCustomName(): ?TextComponent
    {
        return $this->customName;
    }

    public function isCustomNameVisible(): bool
    {
        return $this->customNameVisible;
    }

    public function setCustomNameVisible(bool $visible): void
    {
        $this->customNameVisible = $visible;
    }

    public function isSilent(): bool
    {
        return $this->silent;
    }

    public function setSilent(bool $silent): void
    {
        $this->silent = $silent;
    }

    public function hasGravity(): bool
    {
        return $this->gravity;
    }

    public function setGravity(bool $gravity): void
    {
        $this->gravity = $gravity;
    }

    public function getPose(): Pose
    {
        return $this->pose;
    }

    public function setPose(Pose $pose): void
    {
        $this->pose = $pose;
    }

    /**
     * @return EntityType
     */
    abstract function getType(): EntityType;
}