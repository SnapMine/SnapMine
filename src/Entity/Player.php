<?php

namespace SnapMine\Entity;

use SnapMine\Component\TextComponent;
use SnapMine\Inventory\Inventory;
use SnapMine\Inventory\ItemStack;
use SnapMine\Inventory\PlayerInventory;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Packet\Clientbound\Play\ContainerSetContentPacket;
use SnapMine\Network\Packet\Clientbound\Play\DisconnectPacket;
use SnapMine\Network\Packet\Clientbound\Play\MoveEntityPosPacket;
use SnapMine\Network\Packet\Clientbound\Play\MoveEntityRotPacket;
use SnapMine\Network\Packet\Clientbound\Play\OpenScreenPacket;
use SnapMine\Network\Packet\Clientbound\Play\RotateHeadPacket;
use SnapMine\Network\Packet\Clientbound\Play\SoundPacket;
use SnapMine\Network\Packet\Clientbound\Play\SystemChatPacket;
use SnapMine\Session\Session;
use SnapMine\Sound\Sound;
use SnapMine\Sound\SoundCategory;
use SnapMine\Utils\UUID;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\Location;
use SnapMine\World\Position;
use SnapMine\World\World;

/**
 * Represents a player entity connected to the server.
 * 
 * Players are special entities that represent human players connected
 * to the server. They have additional capabilities like inventories,
 * game modes, chat functionality, and network session management.
 * 
 * Players extend LivingEntity and inherit all entity functionality
 * while adding player-specific features like messaging, item management,
 * and administrative actions.
 * 
 * @since   0.0.1
 * 
 * @example
 * ```php
 * // Send a message to the player
 * $player->sendMessage("Welcome to the server!");
 * 
 * // Change game mode
 * $player->setGameMode(GameMode::CREATIVE);
 * 
 * // Give an item
 * $player->give(new ItemStack(Material::DIAMOND, 64));
 * ```
 */
class Player extends LivingEntity
{
    /**
     * Last keep-alive packet ID sent to this player.
     * Used for connection monitoring and latency calculation.
     * 
     * @var int
     */
    public int $lastKeepAliveId = 0;
    
    /**
     * Current game mode of the player.
     * 
     * @var GameMode
     */
    private GameMode $gameMode = GameMode::SURVIVAL;
    
    /**
     * Previous game mode before the current one.
     * Used for restoring game mode when needed.
     * 
     * @var GameMode|null
     */
    private ?GameMode $previousGameMode = null;
    
    /**
     * Player's inventory containing items and equipment.
     * 
     * @var PlayerInventory
     */
    private PlayerInventory $inventory;

    /**
     * Create a new player instance.
     * 
     * @param Session     $session  The network session for this player
     * @param GameProfile $profile  The player's profile information
     * @param Location    $location The initial spawn location
     */
    public function __construct(
        private readonly Session     $session,
        private readonly GameProfile $profile,
        Location                     $location,
    )
    {
        parent::__construct($this->session->getServer(), $location);

        $this->inventory = new PlayerInventory();
    }

    /**
     * Get the player's UUID.
     * 
     * @return UUID The player's unique identifier
     */
    public function getUuid(): UUID
    {
        return $this->profile->getUuid();
    }

    /**
     * Get the player's username.
     * 
     * @return string The player's display name
     */
    public function getName(): string
    {
        return $this->profile->getName();
    }

    /**
     * Get the player's look vector based on their yaw and pitch.
     * 
     * The look vector is a 3D unit vector that indicates the direction
     * the player is looking. This is useful for raytracing, projectile
     * trajectories, and determining what the player is looking at.
     * 
     * @return Position A 3D vector representing the look direction
     * 
     * @example
     * ```php
     * $lookVector = $player->getLookVector();
     * // Use for raytracing to find what block player is looking at
     * $targetBlock = $world->rayTrace($player->getLocation(), $lookVector, 5.0);
     * ```
     */
    public function getLookVector(): Position
    {
        $yawRad = deg2rad($this->location->getYaw());
        $pitchRad = deg2rad($this->location->getPitch());

        return new Position(
            cos($yawRad) * cos($pitchRad),
            sin($pitchRad),
            sin($yawRad) * cos($pitchRad)
        );
    }

    /**
     * Send a packet to this player.
     *
     * @param ClientboundPacket $packet The packet to send
     * @return void
     */
    public function sendPacket(ClientboundPacket $packet): void
    {
        $this->session->sendPacket($packet);
    }

    /**
     * Get the player's current game mode.
     * 
     * @return GameMode The current game mode
     */
    public function getGameMode(): GameMode
    {
        return $this->gameMode;
    }

    /**
     * Set the player's game mode.
     * 
     * @param GameMode $gameMode The new game mode to set
     * @return void
     */
    public function setGameMode(GameMode $gameMode): void
    {
        $this->previousGameMode = $this->gameMode;
        $this->gameMode = $gameMode;
    }

    /**
     * Get the player's previous game mode.
     * 
     * @return GameMode|null The previous game mode, or null if none
     */
    public function getPreviousGameMode(): ?GameMode
    {
        return $this->previousGameMode;
    }

    /**
     * Play a sound for this player.
     * 
     * @param Entity|Location $location The location where the sound originates
     * @param Sound          $sound    The sound to play
     * @param SoundCategory  $category The sound category for volume control
     * @param float          $volume   The volume level (0.0 to 1.0)
     * @param float          $pitch    The pitch modifier (0.5 to 2.0)
     * @param int            $seed     Random seed for sound variation
     * @return void
     */
    public function playSound(Entity|Location $location, Sound $sound, SoundCategory $category, float $volume = 1.0, float $pitch = 2.0, int $seed = 1): void
    {
        if ($location instanceof Entity) {
            $location = $location->getLocation();
        }

        $packet = new SoundPacket(
            $sound,
            $category,
            (int)$location->getX(),
            (int)$location->getY(),
            (int)$location->getZ(),
            $volume,
            $pitch,
            $seed
        );

        $this->sendPacket($packet);
    }

    /**
     * Get the entity type for players.
     * 
     * @return EntityType Always returns EntityType::PLAYER
     */
    public function getType(): EntityType
    {
        return EntityType::PLAYER;
    }

    /**
     * Transfer the player to another server.
     * 
     * @param string $host The target server hostname or IP
     * @param int    $port The target server port
     * @return void
     * 
     * @throws \Exception If transfer fails
     */
    public function transfer(string $host, int $port): void
    {
        $this->session->transfer($host, $port);
    }

    /**
     * Get the chunk the player is currently in.
     * 
     * @return Chunk The current chunk
     */
    public function getChunk(): Chunk
    {
        return $this->server->getWorld("world")->getChunk($this->location->getX() >> 4, $this->location->getZ() >> 4);
    }

    /**
     * Send a chat message to this player.
     * 
     * @param TextComponent|string $message The message to send
     * @return void
     */
    public function sendMessage(TextComponent|string $message): void
    {
        if (is_string($message)) {
            $message = TextComponent::text($message);
        }

        $this->sendPacket(new SystemChatPacket($message, false));
    }

    /**
     * Disconnect the player with a reason.
     * 
     * @param TextComponent|string $reason The reason for disconnection
     * @return void
     */
    public function kick(TextComponent|string $reason): void
    {
        if (is_string($reason)) {
            $reason = TextComponent::text($reason);
        }

        $packet = new DisconnectPacket($reason);

        $this->sendPacket($packet);
    }

    /**
     * Get the world the player is currently in.
     * 
     * @return World The current world
     */
    public function getWorld(): World
    {
        return $this->location->getWorld();
    }

    /**
     * Get the player's inventory.
     * 
     * @return PlayerInventory The player's inventory instance
     */
    public function getInventory(): PlayerInventory
    {
        return $this->inventory;
    }

    /**
     * Give an item stack to the player.
     * 
     * Attempts to add the item to the player's inventory and
     * updates the client with the new inventory contents.
     * 
     * @param ItemStack $item The item stack to give
     * @return void
     */
    public function give(ItemStack $item): void
    {
        $this->inventory->addItem($item);

        $this->sendPacket(new ContainerSetContentPacket($this->inventory));
    }

    public function openInventory(Inventory $inventory): void
    {
        static $i = 1;

        if ($i > 100) {
            $i = 1;
        }

        $this->sendPacket(new OpenScreenPacket($i, $inventory->getType(), $inventory->getTitle()));

        $i++;
    }

//    public function move(Position $position, float $yaw = 0.0, float $pitch = 0.0): void
//    {
//        $loc = $this->getLocation();
//
//        $factor = 4096;
//
//        $deltaX = (int)(($position->getX() - $loc->getX()) * $factor);
//        $deltaY = (int)(($position->getY() - $loc->getY()) * $factor);
//        $deltaZ = (int)(($position->getZ() - $loc->getZ()) * $factor);
//
//        $maxDelta = 32767; // max short
//        if (abs($deltaX) > $maxDelta || abs($deltaY) > $maxDelta || abs($deltaZ) > $maxDelta) {
//            return;
//        }
//
//        $loc->setX($position->getX());
//        $loc->setY($position->getY());
//        $loc->setZ($position->getZ());
//
//        if ($yaw === 0.0 && $pitch === 0.0) {
//            $outPacket = new MoveEntityPosPacket(
//                $this->getId(),
//                $deltaX,
//                $deltaY,
//                $deltaZ,
//                false
//            );
//
//            $this->getServer()->broadcastPacket($outPacket, fn(Player $p) => $p->getUuid() != $this->getUuid());
//        } else {
//            $loc->setYaw($yaw);
//            $loc->setPitch($pitch);
//
//            $packet = new MoveEntityRotPacket($this, false);
//            $this->getServer()->broadcastPacket($packet, fn(Player $p) => $p->getUuid() != $this->getUuid());
//        }
//    }
}