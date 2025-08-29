<?php

namespace SnapMine\Entity;

use SnapMine\Component\TextComponent;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Packet\Clientbound\Play\MoveEntityPosPacket;
use SnapMine\Network\Packet\Clientbound\Play\MoveEntityRotPacket;
use SnapMine\Network\Packet\Clientbound\Play\RotateHeadPacket;
use SnapMine\Network\Packet\Clientbound\Play\SoundPacket;
use SnapMine\Network\Packet\Clientbound\Play\SystemChatPacket;
use SnapMine\Network\Packet\Packet;
use SnapMine\Session\Session;
use SnapMine\Sound\Sound;
use SnapMine\Sound\SoundCategory;
use SnapMine\Utils\UUID;
use SnapMine\World\Chunk\Chunk;
use SnapMine\World\Location;
use SnapMine\World\Position;

class Player extends LivingEntity
{
    public int $lastKeepAliveId = 0;
    private GameMode $gameMode = GameMode::SURVIVAL;
    private ?GameMode $previousGameMode = null;

    public function __construct(
        private readonly Session     $session,
        private readonly GameProfile $profile,
        Location                     $location,
    )
    {
        parent::__construct($this->session->getServer(), $location);
    }

    /**
     * Get the player's UUID.
     *
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->profile->getUuid();
    }

    /**
     * Get the player's name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->profile->getName();
    }

    /**
     * Get the player's look vector based on their yaw and pitch.
     *
     * The look vector is a 3D vector that indicates the direction the player is looking at.
     *
     * @return Position
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
     * Send packet
     *
     * @param ClientboundPacket $packet
     * @return void
     */
    public function sendPacket(ClientboundPacket $packet): void
    {
        $this->session->sendPacket($packet);
    }

    /**
     * @return GameMode
     */
    public function getGameMode(): GameMode
    {
        return $this->gameMode;
    }

    /**
     * @param GameMode $gameMode
     */
    public function setGameMode(GameMode $gameMode): void
    {
        $this->previousGameMode = $this->gameMode;
        $this->gameMode = $gameMode;
    }

    /**
     * @return GameMode|null
     */
    public function getPreviousGameMode(): ?GameMode
    {
        return $this->previousGameMode;
    }

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

    public function getType(): EntityType
    {
        return EntityType::PLAYER;
    }

    /**
     * @throws \Exception
     */
    public function transfer(string $host, int $port): void
    {
        $this->session->transfer($host, $port);
    }

    public function getChunk(): Chunk
    {
        return $this->server->getWorld("world")->getChunk($this->location->getX() >> 4, $this->location->getZ() >> 4);
    }

    public function sendMessage(TextComponent|string $message): void
    {
        if (is_string($message)) {
            $message = TextComponent::text($message);
        }

        $this->sendPacket(new SystemChatPacket($message, false));
    }

    public function move(Position $position, float $yaw = 0.0, float $pitch = 0.0): void
    {
        $loc = $this->getLocation();

        $factor = 4096;

        $deltaX = (int)(($position->getX() - $loc->getX()) * $factor);
        $deltaY = (int)(($position->getY() - $loc->getY()) * $factor);
        $deltaZ = (int)(($position->getZ() - $loc->getZ()) * $factor);

        $maxDelta = 32767; // max short
        if (abs($deltaX) > $maxDelta || abs($deltaY) > $maxDelta || abs($deltaZ) > $maxDelta) {
            return;
        }

        $loc->setX($position->getX());
        $loc->setY($position->getY());
        $loc->setZ($position->getZ());

        if ($yaw === 0.0 && $pitch === 0.0) {
            $outPacket = new MoveEntityPosPacket(
                $this->getId(),
                $deltaX,
                $deltaY,
                $deltaZ,
                false
            );

            $this->getServer()->broadcastPacket($outPacket, fn(Player $p) => $p->getUuid()->equals($this->getUuid()));
        } else {
            $loc->setYaw($yaw);
            $loc->setPitch($pitch);

            $packet = new MoveEntityRotPacket($this, false);
            $headRotatePacket = new RotateHeadPacket($this);

            $this->getServer()->broadcastPacket($headRotatePacket, fn (Player $p) => $p->getUuid()->equals($this->getUuid()));
            $this->getServer()->broadcastPacket($packet, fn (Player $p) => $p->getUuid()->equals($this->getUuid()));
        }
    }
}