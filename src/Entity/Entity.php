<?php

namespace SnapMine\Entity;

use SnapMine\Component\TextComponent;
use SnapMine\Entity\Metadata\Metadata;
use SnapMine\Entity\Metadata\MetadataType;
use SnapMine\Network\Packet\Clientbound\Play\EntityPositionSyncPacket;
use SnapMine\Network\Packet\Clientbound\Play\SetEntityDataPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Server;
use SnapMine\Utils\UUID;
use SnapMine\World\Location;

/**
 * Abstract base class for all entities in the game world.
 * 
 * This class provides the fundamental properties and behaviors that all entities
 * share, including position, state flags, metadata management, and basic entity
 * properties like visibility, pose, and custom names.
 * 
 * Entities are objects that exist in the world and can be interacted with,
 * including players, mobs, items, projectiles, and other dynamic objects.
 * 
 * @since   0.0.1
 * 
 * @example
 * ```php
 * class MyEntity extends Entity {
 *     public function getType(): EntityType {
 *         return EntityType::CUSTOM;
 *     }
 * }
 * 
 * $entity = new MyEntity($server, $location);
 * $entity->setCustomName("My Custom Entity");
 * $entity->setGlowing(true);
 * ```
 */
abstract class Entity
{
    /**
     * Internal entity ID unique within the server instance.
     * This ID is used for network communication and entity tracking.
     * 
     * @var int
     */
    protected int $internalId;
    
    /**
     * Universally unique identifier for this entity.
     * UUIDs are used for persistent entity identification across sessions.
     * 
     * @var UUID
     */
    protected UUID $uuid;
    
    /**
     * Packet serializer buffer for entity data.
     * Used for temporary data serialization during packet creation.
     * 
     * @var PacketSerializer
     */
    protected PacketSerializer $buffer;
    
    /**
     * Entity state flags stored as a bitmask.
     * Contains various boolean states like on fire, sneaking, sprinting, etc.
     * 
     * @var int
     */
    private int $state = 0;
    
    /**
     * Number of ticks the entity can survive underwater.
     * Decreases when underwater, increases when in air. Default is 300 ticks (15 seconds).
     * 
     * @var int
     */
    private int $airTicks = 300;
    
    /**
     * Custom display name for the entity.
     * If null, the entity uses its default name.
     * 
     * @var TextComponent|null
     */
    private ?TextComponent $customName = null;
    
    /**
     * Whether the custom name is visible above the entity.
     * Only relevant when customName is not null.
     * 
     * @var bool
     */
    private bool $customNameVisible = false;
    
    /**
     * Whether the entity makes sounds.
     * Silent entities don't produce footsteps, damage sounds, etc.
     * 
     * @var bool
     */
    private bool $silent = false;
    
    /**
     * Whether the entity is affected by gravity.
     * Entities without gravity don't fall or move due to physics.
     * 
     * @var bool
     */
    private bool $gravity = false;
    
    /**
     * Current pose/animation state of the entity.
     * Determines how the entity is visually displayed.
     * 
     * @var Pose
     */
    private Pose $pose = Pose::STANDING;

    use Metadata;

    /**
     * Create a new entity instance.
     * 
     * @param Server   $server   The server instance this entity belongs to
     * @param Location $location The initial location of the entity
     */
    public function __construct(
        protected Server   $server,
        protected Location $location,
    )
    {
        $this->internalId = $this->server->incrementAndGetId();
        $this->uuid = UUID::generate();
        $this->buffer = new PacketSerializer("");
    }

    /**
     * Get the internal entity ID.
     * 
     * @return int The unique internal ID of this entity
     */
    public function getId(): int
    {
        return $this->internalId;
    }

    /**
     * Get the entity's UUID.
     * 
     * @return UUID The universally unique identifier for this entity
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * Get the entity's current location.
     * 
     * @return Location The current position and world of the entity
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * Check if the entity is on fire.
     * 
     * @return bool True if the entity is burning, false otherwise
     */
    public function isOnFire(): bool
    {
        return ($this->state & 0x01) !== 0;
    }

    /**
     * Set whether the entity is on fire.
     * 
     * @param bool $state True to set the entity on fire, false to extinguish
     * @return void
     */
    public function setOnFire(bool $state): void
    {
        $this->setState(0x01, $state);
    }

    /**
     * Check if the entity is sneaking.
     * 
     * @return bool True if the entity is in sneaking state, false otherwise
     */
    public function isSneaking(): bool
    {
        return ($this->state & 0x02) !== 0;
    }

    /**
     * Set whether the entity is sneaking.
     * 
     * @param bool $state True to make the entity sneak, false to stop sneaking
     * @return void
     */
    public function setSneaking(bool $state): void
    {
        $this->setState(0x02, $state);
    }

    /**
     * Check if the entity is sprinting.
     * 
     * @return bool True if the entity is sprinting, false otherwise
     */
    public function isSprinting(): bool
    {
        return ($this->state & 0x08) !== 0;
    }

    /**
     * Set whether the entity is sprinting.
     * 
     * @param bool $state True to make the entity sprint, false to stop sprinting
     * @return void
     */
    public function setSprinting(bool $state): void
    {
        $this->setState(0x08, $state);
    }

    /**
     * Check if the entity is swimming.
     * 
     * @return bool True if the entity is in swimming state, false otherwise
     */
    public function isSwimming(): bool
    {
        return ($this->state & 0x10) !== 0;
    }

    /**
     * Set whether the entity is swimming.
     * 
     * @param bool $state True to make the entity swim, false to stop swimming
     * @return void
     */
    public function setSwimming(bool $state): void
    {
        $this->setState(0x10, $state);
    }

    /**
     * Check if the entity is invisible.
     * 
     * @return bool True if the entity is invisible, false otherwise
     */
    public function isInvisible(): bool
    {
        return ($this->state & 0x20) !== 0;
    }

    /**
     * Set whether the entity is invisible.
     * 
     * @param bool $state True to make the entity invisible, false to make it visible
     * @return void
     */
    public function setInvisible(bool $state): void
    {
        $this->setState(0x20, $state);
    }

    /**
     * Check if the entity is glowing.
     * 
     * @return bool True if the entity has a glowing outline, false otherwise
     */
    public function isGlowing(): bool
    {
        return ($this->state & 0x40) !== 0;
    }

    /**
     * Set whether the entity is glowing.
     * 
     * @param bool $state True to make the entity glow, false to remove the glow
     * @return void
     */
    public function setGlowing(bool $state): void
    {
        $this->setState(0x40, $state);
    }

    /**
     * Internal method to set entity state bits and update metadata.
     * 
     * @param int  $bit The bit position to modify
     * @param bool $set True to set the bit, false to clear it
     * @return void
     */
    private function setState(int $bit, bool $set): void
    {
        if ($set) {
            $this->state |= $bit;
        } else {
            $this->state &= ~$bit;
        }

        $this->setMetadata(0, MetadataType::BYTE, $this->state);
    }

    /**
     * Get the entity's remaining air ticks.
     * 
     * @return int Number of ticks the entity can survive underwater
     */
    public function getAirTicks(): int
    {
        return $this->airTicks;
    }

    /**
     * Set the entity's remaining air ticks.
     * 
     * @param int $airTicks Number of ticks the entity can survive underwater
     * @return void
     */
    public function setAirTicks(int $airTicks): void
    {
        $this->airTicks = $airTicks;

        $this->setMetadata(1, MetadataType::VAR_INT, $this->airTicks);
    }

    /**
     * Set the custom name displayed above the entity.
     * 
     * @param TextComponent|string $customName The custom name to display
     * @param bool                 $visible    Whether the name should be visible
     * @return void
     */
    public function setCustomName(TextComponent|string $customName, bool $visible = true): void
    {
        if (is_string($customName)) {
            $customName = TextComponent::text($customName);
        }

        $this->customName = $customName;

        $this->setMetadata(2, MetadataType::OPTIONAL_TEXT_COMPONENT, $this->customName);
        $this->setCustomNameVisible($visible);
    }

    /**
     * Get the entity's custom name.
     * 
     * @return TextComponent|null The custom name, or null if no custom name is set
     */
    public function getCustomName(): ?TextComponent
    {
        return $this->customName;
    }

    /**
     * Check if the custom name is visible.
     * 
     * @return bool True if the custom name is displayed above the entity
     */
    public function isCustomNameVisible(): bool
    {
        return $this->customNameVisible;
    }

    /**
     * Set whether the custom name is visible.
     * 
     * @param bool $visible True to show the custom name, false to hide it
     * @return void
     */
    public function setCustomNameVisible(bool $visible): void
    {
        $this->customNameVisible = $visible;

        $this->setMetadata(3, MetadataType::BOOLEAN, $this->customNameVisible);
    }

    /**
     * Check if the entity is silent.
     * 
     * @return bool True if the entity doesn't make sounds, false otherwise
     */
    public function isSilent(): bool
    {
        return $this->silent;
    }

    /**
     * Set whether the entity is silent.
     * 
     * @param bool $silent True to make the entity silent, false to enable sounds
     * @return void
     */
    public function setSilent(bool $silent): void
    {
        $this->silent = $silent;

        $this->setMetadata(4, MetadataType::BOOLEAN, $this->silent);
    }

    /**
     * Check if the entity is affected by gravity.
     * 
     * @return bool True if the entity falls due to gravity, false otherwise
     */
    public function hasGravity(): bool
    {
        return $this->gravity;
    }

    /**
     * Set whether the entity is affected by gravity.
     * 
     * @param bool $gravity True to enable gravity, false to disable it
     * @return void
     */
    public function setGravity(bool $gravity): void
    {
        $this->gravity = $gravity;

        $this->setMetadata(5, MetadataType::BOOLEAN, !$this->gravity);
    }

    /**
     * Get the entity's current pose.
     * 
     * @return Pose The current pose/animation state
     */
    public function getPose(): Pose
    {
        return $this->pose;
    }

    /**
     * Set the entity's pose.
     * 
     * @param Pose $pose The new pose/animation state
     * @return void
     */
    public function setPose(Pose $pose): void
    {
        $this->pose = $pose;

        $this->setMetadata(6, MetadataType::POSE, $this->pose);
    }

    /**
     * Get the server instance this entity belongs to.
     * 
     * @return Server The server instance
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * Teleport the entity to a new location.
     *
     * This method creates and broadcasts an {@see EntityPositionSyncPacket}
     * to all connected players in order to instantly update the entity's
     * position and orientation on the client side.
     *
     * @param Location $location The destination location
     * @return void
     */
    public function teleport(Location $location): void
    {
        $packet = new EntityPositionSyncPacket(
            $this->getId(),
            $location->getX(),
            $location->getY(),
            $location->getZ(),
            0,
            0,
            0,
            $location->getYaw(),
            $location->getPitch(),
            true
        );

        $this->location = clone $location;

        $this->getServer()->broadcastPacket($packet);
    }

    /**
     * Update the entity and broadcast changes to all players.
     * 
     * This method sends the entity's current metadata to all connected players.
     * Call this after making changes to entity properties to sync them.
     * 
     * @return void
     */
    public function update(): void
    {
        $this->server->broadcastPacket(new SetEntityDataPacket($this));
    }

    /**
     * Get the type of this entity.
     * 
     * This method must be implemented by concrete entity classes to specify
     * what type of entity this instance represents.
     * 
     * @return EntityType The type identifier for this entity
     */
    abstract public function getType(): EntityType;
}