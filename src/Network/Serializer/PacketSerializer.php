<?php

namespace Nirbose\PhpMcServ\Network\Serializer;

use Aternos\Nbt\IO\Writer\StringWriter;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\FloatTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use Nirbose\PhpMcServ\Utils\UUID;
use Nirbose\PhpMcServ\World\Position;

class PacketSerializer
{

    private string $payload = "";

    public function put(string $data): void
    {
        $this->payload .= $data;
    }

    public function get(): string
    {
        return $this->payload;
    }

    /**
     * Encode un entier en utilisant le format VarInt.
     *
     * @param integer $value
     * @return void
     */
    public function putVarInt(int $value): void
    {
        $out = '';
        do {
            $temp = $value & 0x7F;
            $value >>= 7;
            if ($value !== 0) $temp |= 0x80;
            $out .= chr($temp);
        } while ($value !== 0);

        $this->put($out);
    }

    /**
     * Lit un entier en utilisant le format VarInt.
     *
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getVarInt(string $buffer, int &$offset): int
    {
        $value = 0;
        $position = 0;
        while (true) {
            if (!isset($buffer[$offset])) {
                throw new \Exception("Fin du buffer pendant lecture VarInt");
            }

            $byte = ord($buffer[$offset++]);
            $value |= ($byte & 0x7F) << $position;

            if (($byte & 0x80) === 0) break;

            $position += 7;
            if ($position > 35) {
                throw new \Exception("VarInt trop longue");
            }
        }

        return $value;
    }

    /**
     * Encode une chaîne de caractères en utilisant le format VarString.
     *
     * @param string $data
     * @return void
     */
    public function putString(string $data): void
    {
        $this->put($this->putVarInt(strlen($data)) . $data);
    }

    /**
     * Lit une chaîne de caractères en utilisant le format VarString.
     *
     * @param string $buffer
     * @param integer $offset
     * @return string
     */
    public function getString(string $buffer, int &$offset): string
    {
        $len = $this->getVarInt($buffer, $offset);
        $str = substr($buffer, $offset, $len);

        if (strlen($str) < $len) {
            throw new \Exception("Chaîne tronquée (attendu $len octets, reçu " . strlen($str) . ")");
        }

        $offset += $len;

        return $str;
    }

    /**
     * Encode un entier 16 bits en utilisant le format Big Endian.
     *
     * @param integer $value
     * @return void
     */
    public function putShort(int $value): void
    {
        $this->put(pack('n', $value));
    }

    /**
     * Lit un entier 16 bits en utilisant le format Big Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getShort(string $buffer, int &$offset): int
    {
        $value = unpack('n', substr($buffer, $offset, 2))[1];
        $offset += 2;

        return $value;
    }

    /**
     * Encode un entier 32 bits en utilisant le format Big Endian.
     *
     * @param integer $value
     * @return void
     */
    public function putInt(int $value): void
    {
        $this->put(pack('N', $value));
    }

    /**
     * Lit un entier 32 bits en utilisant le format Big Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getInt(string $buffer, int &$offset): int
    {
        $value = unpack('N', substr($buffer, $offset, 4))[1];
        $offset += 4;

        return $value;
    }

    /**
     * Encode un entier 64 bits en utilisant le format Big Endian.
     *
     * @param integer|string $value
     * @return void
     */
    public function putLong(int|string $value): void
    {
        if (is_string($value)) {
            $value = gmp_init($value);
            $bin = gmp_export($value);
            $bin = str_pad($bin, 8, "\x00", STR_PAD_LEFT);
        } else {
            $bin = pack('J', $value);
        }

        $this->put($bin);
    }

    /**
     * Lit un entier 64 bits en utilisant le format Big Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getLong(string $buffer, int &$offset): int
    {
        if (strlen($buffer) < $offset + 8) {
            throw new \Exception("Pas assez de données pour lire un Long");
        }

        $data = substr($buffer, $offset, 8);
        $offset += 8;

        $parts = unpack('J', $data);
        return $parts[1];
    }

    /**
     * Encode un float en utilisant le format Big Endian.
     *
     * @param float $value
     * @return void
     */
    public function putFloat(float $value): void
    {
        $this->put(pack('G', $value));
    }

    /**
     * Lit un float en utilisant le format Big Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return float
     */
    public function getFloat(string $buffer, int &$offset): float
    {
        $value = unpack('G', substr($buffer, $offset, 4))[1];
        $offset += 4;

        return $value;
    }

    /**
     * Encode un double en utilisant le format Big Endian.
     *
     * @param float $value
     * @return void
     */
    public function putDouble(float $value): void
    {
        $this->put(pack('E', $value));
    }

    /**
     * Lit un double en utilisant le format Big Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return float
     */
    public function getDouble(string $buffer, int &$offset): float
    {
        $value = unpack('E', substr($buffer, $offset, 8))[1];
        $offset += 8;

        return $value;
    }

    /**
     * Encode un booléen.
     *
     * @param boolean $value
     * @return void
     */
    public function putBool(bool $value): void
    {
        $this->put($value ? "\x01" : "\x00");
    }

    /**
     * Lit un booléen.
     *
     * @param string $buffer
     * @param integer $offset
     * @return boolean
     */
    public function getBool(string $buffer, int &$offset): bool
    {
        $value = ord($buffer[$offset++]);
        if ($value !== 0 && $value !== 1) {
            throw new \Exception("Valeur booléenne invalide");
        }

        return (bool)$value;
    }

    /**
     * Encode un byte.
     * 
     * @param integer $value
     * @return void
     */
    public function putByte(int $value): void
    {
        $this->put(chr($value));
    }

    /**
     * Lit un byte.
     * 
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getByte(string $buffer, int &$offset): int
    {
        $value = ord($buffer[$offset++]);
        if ($value < 0 || $value > 255) {
            throw new \Exception("Valeur de byte invalide");
        }

        return $value;
    }

    /**
     * Encode un prefixed array.
     * 
     * @param array $array
     * @return void
     */
    public function putPrefixedArray(array $array): void
    {
        $this->putVarInt(count($array));
        foreach ($array as $item) {
            $this->putString($item);
        }
    }

    /**
     * Lit un prefixed array.
     * 
     * @param string $buffer
     * @param integer $offset
     * @return array
     */
    public function getPrefixedArray(string $buffer, int &$offset): array
    {
        $length = $this->getVarInt($buffer, $offset);
        $array = [];
        for ($i = 0; $i < $length; $i++) {
            $array[] = substr($buffer, $offset, 1);
            $offset++;
        }

        return $array;
    }

    /**
     * Encode un UUID.
     * 
     * @param string|UUID $uuid
     * @return void
     */
    public function putUUID(string|UUID $uuid): void
    {
        if ($uuid instanceof UUID) {
            $uuid = $uuid->toString();
        }

        $raw = pack('H*', str_replace('-', '', $uuid));

        $this->put($raw);
    }

    /**
     * Lit un UUID.
     * 
     * @param string $buffer
     * @param integer $offset
     * @return string
     */
    public function getUUID(string $buffer, int &$offset): UUID
    {
        $uuid = substr($buffer, $offset, 16);
        $offset += 16;

        return UUID::fromString($uuid);
    }

    /**
     * Encode une Position code sur 64 bits.
     * x (-33554432 to 33554431), z (-33554432 to 33554431), y (-2048 to 2047)
     * 
     * @param integer $x
     * @param integer $y
     * @param integer $z
     * @return void
     */
    public function putPosition(int $x, int $y, int $z): void
    {
        $this->putLong(
            (($x & 0x3FFFFFF) << 38) | (($z & 0x3FFFFFF) << 12) | ($y & 0xFFF)
        );
    }

    /**
     * Lit une Position code sur 64 bits.
     * x (-33554432 to 33554431), z (-33554432 to 33554431), y (-2048 to 2047)
     * 
     * @param string $buffer
     * @param integer $offset
     * @return Position
     */
    public function getPosition(string $buffer, int &$offset): Position
    {
        $value = $this->getLong($buffer, $offset);
        $x = $value >> 38;
        $y = $value << 52 >> 52;
        $z = $value << 26 >> 38;

        return new Position(
            $x,
            $y,
            $z
        );
    }

    /**
     * Encode un unsigned short.
     * 
     * @param integer $value
     * @return void
     */
    public function putUnsignedShort(int $value): void
    {
        if ($value < 0 || $value > 65535) {
            throw new \Exception("Valeur de short invalide");
        }
        $this->put(pack('n', $value));
    }

    /**
     * Lit un unsigned short.
     * 
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getUnsignedShort(string $buffer, int &$offset): int
    {
        $value = unpack('n', substr($buffer, $offset, 2))[1];
        $offset += 2;

        if ($value < 0 || $value > 65535) {
            throw new \Exception("Valeur de short invalide");
        }

        return $value;
    }

    /**
     * Encode un byte array binaire (comme utilisé par NBT ou d'autres données binaires).
     * 
     * @param string $data Données binaires (ex: issues du writer NBT)
     * @return void
     */
    public function putByteArray(string $data): void
    {
        $this->putVarInt(strlen($data)); // Longueur d'abord
        $this->put($data); // Puis contenu binaire brut
    }

    /**
     * Lit un byte array.
     * 
     * @param string $buffer
     * @param integer $offset
     * @return array
     */
    public function getByteArray(string $buffer, int &$offset): array
    {
        $length = $this->getVarInt($buffer, $offset);
        $data = substr($buffer, $offset, $length);
        $offset += $length;

        if (strlen($data) < $length) {
            throw new \Exception("Byte array tronqué (attendu $length octets, reçu " . strlen($data) . ")");
        }

        return array_values(unpack('C*', $data));
    }

    /**
     * Encode un unsigned byte.
     * 
     * @param integer $value
     * @return void
     */
    public function putUnsignedByte(int $value): void
    {
        if ($value < 0 || $value > 255) {
            throw new \Exception("Valeur de byte invalide");
        }
        $this->put(pack('C', $value));
    }

    /**
     * Lit un unsigned byte.
     * 
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getUnsignedByte(string $buffer, int &$offset): int
    {
        $value = ord($buffer[$offset++]);
        if ($value < 0 || $value > 255) {
            throw new \Exception("Valeur de byte invalide");
        }

        return $value;
    }

    public function putUnsignedLong(int $value): void
    {
        if ($value < 0 || $value > 0xFFFFFFFFFFFFFFFF) {
            throw new \Exception("Valeur de long invalide");
        }
        $this->put(pack('P', $value));
    }
}