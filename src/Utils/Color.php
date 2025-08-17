<?php

namespace Nirbose\PhpMcServ\Utils;

use Exception;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\Serializer\ProtocolEncodable;

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
     * @throws Exception
     */
    public static function fromHex(string $hex): Color
    {
        if (strlen($hex) === 6) {
            if ($hex[0] === '#') {
                $hex = substr($hex, 1);
            }

            return new self((int)hexdec($hex));
        }

        throw new Exception('Invalid hex color');
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

    public function toPacket(PacketSerializer $serializer): void
    {
        $serializer->putInt($this->color);
    }
}