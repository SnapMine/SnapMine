<?php

namespace Nirbose\PhpMcServ\Entity;

use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Location;
use Nirbose\PhpMcServ\World\Position;

class Player
{
    private int $id;
    private string $username;
    private UUID $uuid;
    private Location|null $location = null;

    public function __construct(int $id, string $username, UUID $uuid)
    {
        $this->id = $id;
        $this->username = $username;
        $this->uuid = $uuid;
    }

    /**
     * Get the player's ID.
     * 
     * The ID is a unique identifier for the player within the server.
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
        return $this->uuid;
    }

    /**
     * Get the player's username.
     * 
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the player's username.
     * 
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
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
}