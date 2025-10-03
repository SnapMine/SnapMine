<?php

namespace SnapMine\Command\ArgumentTypes;

use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\World\Position;

/**
 * Represents a Minecraft Vec3 argument type (3D coordinates).
 *
 * A Vec3 is a location in 3D space expressed as 3 numbers (X, Y, Z).
 * Each component may be:
 *  - An absolute number (e.g. 10, -5.5, 100.0)
 *  - A relative number with "~" prefix (e.g. ~, ~1, ~-2.5)
 *
 * Example valid inputs:
 *  - "100 64 200"
 *  - "~ ~1 ~-2.5"
 *  - "-10.5 70.25 0"
 *
 * @extends CommandArgumentType<Position>
 */
class ArgumentVec3 extends CommandArgumentType
{
    public const REGEX =
        '/^(?<x>(?:~(?:-?(?:\d+|\d*\.\d+))?|-?(?:\d+|\d*\.\d+)))\s+' .
        '(?<y>(?:~(?:-?(?:\d+|\d*\.\d+))?|-?(?:\d+|\d*\.\d+)))\s+' .
        '(?<z>(?:~(?:-?(?:\d+|\d*\.\d+))?|-?(?:\d+|\d*\.\d+)))$/';

    private Position $value;

    /**
     * Get the numeric ID for this argument type.
     *
     * @return int The Brigadier ID for minecraft:vec3
     */
    public static function getNumericId(): int
    {
        return 10;
    }

    /**
     * Get the parsed Vec3 as a Position object.
     *
     * @return Position
     */
    public function getValue(): Position
    {
        return $this->value;
    }

    /**
     * Set the Vec3 value.
     *
     * @param mixed $value Must be an instance of Position
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Encode additional properties of this argument type.
     * Vec3 has no special properties to encode.
     *
     * @param PacketSerializer $serializer
     * @return void
     */
    public function encodeProperties(PacketSerializer $serializer): void
    {
        // Vec3 has no extra properties
    }

    /**
     * Parse the argument from a list of tokens.
     *
     * @param array $args The remaining arguments to parse
     * @return array|null [newArgs, self] on success, or null on failure
     */
    public function parse(array $args): ?array
    {
        if (count($args) < 3) {
            return null;
        }

        $implode = implode(' ', array_slice($args, 0, 3));

        if (!preg_match(self::REGEX, $implode, $matches)) {
            return null;
        }

        $clone = clone $this;

        // Parse X Y Z with handling for "~"
        $x = $this->parseCoordinate($matches['x']);
        $y = $this->parseCoordinate($matches['y']);
        $z = $this->parseCoordinate($matches['z']);

        $clone->value = new Position($x, $y, $z);

        return [array_slice($args, 3), $clone];
    }

    /**
     * Parse a single coordinate component.
     *
     * @param string $input
     * @return float
     */
    private function parseCoordinate(string $input): float
    {
        if ($input === '~') {
            return 0.0; // relative with no offset
        }

        if (str_starts_with($input, '~')) {
            $offset = substr($input, 1);
            return $offset === '' ? 0.0 : (float)$offset;
        }

        return (float)$input;
    }
}
