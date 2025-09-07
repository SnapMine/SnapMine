<?php

namespace SnapMine\Utils;

use Error;
use Exception;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;

readonly class Color implements ProtocolEncodable
{
    public function __construct(
        private int $color,
    )
    {
    }

    public static function fromRGB(int $r, int $g, int $b): Color
    {
        return new self(($r << 16) + ($g << 8) + $b);
    }

    /**
     * @throws Error
     */
    public static function fromHex(string $hex): Color
    {
        if (strlen($hex) === 6) {
            if ($hex[0] === '#') {
                $hex = substr($hex, 1);
            }

            return new self((int)hexdec($hex));
        }

        throw new Error('Invalid hex color');
    }

    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }

    public function getHexColor(): string
    {
        return dechex($this->color);
    }

    public function encode(PacketSerializer $serializer): void
    {
        $serializer->putInt($this->color);
    }
}