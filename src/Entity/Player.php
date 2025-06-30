<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Network\Packet\Packet;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Location;
use Nirbose\PhpMcServ\World\Position;

class Player
{
    private Location|null $location = null;

    public function __construct(
        private readonly Session     $session,
        private readonly GameProfile $profile
    )
    {
    }

    /**
     * Get the player's current location.
     *
     * The location includes the player's position, yaw, and pitch.
     *
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * Set the player's location.
     *
     * @param Location $location
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
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
}