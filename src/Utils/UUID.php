<?php

namespace Nirbose\PhpMcServ\Utils;

class UUID
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function fromString(string $uuid): self
    {
        $uuid = str_replace(['-', '{', '}'], '', $uuid);
        if (strlen($uuid) !== 32) {
            throw new \InvalidArgumentException('Invalid UUID format');
        }

        $uuid = sprintf(
            '%s-%s-%s-%s-%s',
            substr($uuid, 0, 8),
            substr($uuid, 8, 4),
            substr($uuid, 12, 4),
            substr($uuid, 16, 4),
            substr($uuid, 20)
        );

        return new self($uuid);
    }

    public static function fromBinary(string $binary): self
    {
        if (strlen($binary) !== 16) {
            throw new \InvalidArgumentException('Invalid UUID binary format');
        }

        $uuid = sprintf(
            '%s-%s-%s-%s-%s',
            bin2hex(substr($binary, 0, 4)),
            bin2hex(substr($binary, 4, 2)),
            '4' . bin2hex(substr($binary, 6, 1)),
            dechex(mt_rand(8, 11)) . bin2hex(substr($binary, 7, 1)),
            bin2hex(substr($binary, 8))
        );

        return new self($uuid);
    }

    public static function generateOffline(string $name): self
    {
        $hash = md5("OfflinePlayer:" . $name);
        $uuid = substr($hash, 0, 8) . "-" .
               substr($hash, 8, 4) . "-3" .
               substr($hash, 13, 3) . "-a" .
               substr($hash, 17, 3) . "-" .
               substr($hash, 20, 12);

        return new self($uuid);
    }

    public static function generate(): self
    {
        $uuid = sprintf(
            '%s-%s-%s-%s-%s',
            bin2hex(random_bytes(4)),
            bin2hex(random_bytes(2)),
            '4' . bin2hex(random_bytes(1)),
            dechex(mt_rand(8, 11)) . bin2hex(random_bytes(1)),
            bin2hex(random_bytes(6))
        );

        return new self($uuid);
    }

    public function toBinary(): string
    {
        return pack("H*", str_replace('-', '', $this->uuid));
    }

    public function toString(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

}