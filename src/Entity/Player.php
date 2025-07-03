<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Location;
use Nirbose\PhpMcServ\World\Position;

class Player extends Entity
{
    public int $lastKeepAliveId = 0;

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
     * @param Packet $packet
     * @return void
     */
    public function sendPacket(Packet $packet): void
    {
        $this->session->sendPacket($packet);
    }

    function getType(): EntityType
    {
        return EntityType::PLAYER;
    }
}