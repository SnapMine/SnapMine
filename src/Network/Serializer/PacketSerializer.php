<?php

namespace SnapMine\Network\Serializer;

use Aternos\Nbt\IO\Writer\StringWriter;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\Tag;
use SnapMine\Utils\BitSet;
use SnapMine\Utils\UUID;
use SnapMine\World\Position;

class PacketSerializer
{

    private string $buffer; // Stores packet payload. Used for both reading and writing
    private int $offset; // Offset for reading

    public function __construct(string $payload, int $offset = 0) {
        $this->buffer = $payload;
        $this->offset = $offset;
    }


    public function clear(): void
    {
        $this->buffer = substr($this->buffer, $this->offset);
        $this->offset = 0;
    }
    public function put(string $data): void
    {
        $this->buffer .= $data;
    }

    public function get(): string
    {
        return $this->buffer;
    }

    public function getLengthPrefixedData(): string
    {
        return $this->varInt(strlen($this->buffer)) . $this->buffer;
    }

    public function getOffset(): int {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    private function varInt(int $value): string
    {
        $out = '';
        do {
            $temp = $value & 0x7F;
            $value >>= 7;
            if ($value !== 0) $temp |= 0x80;
            $out .= chr($temp);
        } while ($value !== 0);

        return $out;
    }

    /**
     * Encode un entier en utilisant le format VarInt.
     *
     * @param integer $value
     * @return PacketSerializer $this
     */
    public function putVarInt(int $value): PacketSerializer
    {
        $this->put($this->varInt($value));
        return $this;
    }

    /**
     * Lit un entier en utilisant le format VarInt.
     *
     * @return integer
     * @throws \Exception
     */
    public function getVarInt(): int
    {
        $value = 0;
        $position = 0;
        while (true) {
            if (!isset($this->buffer[$this->offset])) {
                throw new \Exception("Fin du buffer pendant lecture VarInt");
            }

            $byte = ord($this->buffer[$this->offset++]);
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
     * @return PacketSerializer $this
     */
    public function putString(string $data): PacketSerializer
    {
        $this->putVarInt(strlen($data))
            ->put($data);

        return $this;
    }

    /**
     * Lit une chaîne de caractères en utilisant le format VarString.
     *
     * @return string
     * @throws \Exception
     */
    public function getString(): string
    {
        $len = $this->getVarInt();

        return $this->getNBytes($len);
    }


    /**
     * Encode un entier 16 bits en utilisant le format Big Endian.
     *
     * @param integer $value
     * @return PacketSerializer $this
     */
    public function putShort(int $value): PacketSerializer
    {
        $this->put(pack('n', $value));
        return $this;
    }

    /**
     * Lit un entier 16 bits en utilisant le format Big Endian.
     *
     * @return integer
     */
    public function getShort(): int
    {
        $value = unpack('n', substr($this->buffer, $this->offset, 2))[1];
        $this->offset += 2;

        return $value;
    }

    /**
     * Encode un entier 32 bits en utilisant le format Big Endian.
     *
     * @param integer $value
     * @return PacketSerializer
     */
    public function putInt(int $value): PacketSerializer
    {
        $this->put(pack('N', $value));
        return $this;
    }

    /**
     * Lit un entier 32 bits en utilisant le format Big Endian.
     *
     * @return integer
     */
    public function getInt(): int
    {
        $value = unpack('N', substr($this->buffer, $this->offset, 4))[1];
        $this->offset += 4;

        return $value;
    }

    /**
     * Encode un entier 64 bits en utilisant le format Big Endian.
     *
     * @param integer|string $value
     * @return PacketSerializer $this
     */
    public function putLong(int|string $value): PacketSerializer
    {
        if (is_string($value)) {
            $value = gmp_init($value);
            $bin = gmp_export($value);
            $bin = str_pad($bin, 8, "\x00", STR_PAD_LEFT);
        } else {
            $bin = pack('J', $value);
        }

        $this->put($bin);
        return $this;
    }

    /**
     * Lit un entier 64 bits en utilisant le format Big Endian.
     *
     * @return integer
     * @throws \Exception
     */
    public function getLong(): int
    {
        if (strlen($this->buffer) < $this->offset + 8) {
            throw new \Exception("Pas assez de données pour lire un Long");
        }

        $data = substr($this->buffer, $this->offset, 8);
        $this->offset += 8;

        $parts = unpack('J', $data);
        return $parts[1];
    }

    /**
     * Encode un float en utilisant le format Big Endian.
     *
     * @param float $value
     * @return PacketSerializer $this
     */
    public function putFloat(float $value): PacketSerializer
    {
        $this->put(pack('G', $value));
        return $this;
    }

    /**
     * Lit un float en utilisant le format Big Endian.
     *
     * @return float
     */
    public function getFloat(): float
    {
        $value = unpack('G', substr($this->buffer, $this->offset, 4))[1];
        $this->offset += 4;

        return $value;
    }

    /**
     * Encode un double en utilisant le format Big Endian.
     *
     * @param float $value
     * @return PacketSerializer $this
     */
    public function putDouble(float $value): PacketSerializer
    {
        $this->put(pack('E', $value));
        return $this;
    }

    /**
     * Lit un double en utilisant le format Big Endian.
     *
     * @return float
     */
    public function getDouble(): float
    {
        $value = unpack('E', substr($this->buffer, $this->offset, 8))[1];
        $this->offset += 8;

        return $value;
    }

    /**
     * Encode un booléen.
     *
     * @param boolean $value
     * @return PacketSerializer $this
     */
    public function putBool(bool $value): PacketSerializer
    {
        $this->put($value ? "\x01" : "\x00");
        return $this;
    }

    /**
     * Lit un booléen.
     *
     * @return boolean
     */
    public function getBool(): bool
    {
        $value = ord($this->buffer[$this->offset++]);

        return (bool)$value;
    }

    /**
     * Encode un byte.
     * 
     * @param integer $value
     * @return PacketSerializer $this
     */
    public function putByte(int $value): PacketSerializer
    {
        $this->put(chr($value));
        return $this;
    }

    /**
     * Lit un byte.
     *
     * @return integer
     */
    public function getByte(): int
    {
        return ord($this->buffer[$this->offset++]);
    }

    /**
     * Encode un prefixed array.
     * 
     * @param ProtocolDecodable[] $array
     * @return PacketSerializer $this
     */
    public function putPrefixedArray(array $array): PacketSerializer
    {
        $this->putVarInt(count($array));
        foreach ($array as $item) {
            $item->encode($this);
        }
        return $this;
    }

    /**
     * Lit un prefixed array.
     *
     * @return ProtocolDecodable[]
     * @throws \Exception
     */
    public function getPrefixedArray(ProtocolDecodable $decodable): array
    {
        $length = $this->getVarInt();
        $array = [];
        for ($i = 0; $i < $length; $i++) {
            $array[] = $decodable::decode($this);
        }

        return $array;
    }

    /**
     * Encode un UUID.
     * 
     * @param string|UUID $uuid
     * @return PacketSerializer $this
     */
    public function putUUID(string|UUID $uuid): PacketSerializer
    {
        if ($uuid instanceof UUID) {
            $uuid = $uuid->toString();
        }

        $raw = pack('H*', str_replace('-', '', $uuid));

        $this->put($raw);
        return $this;
    }

    /**
     * Lit un UUID.
     *
     * @return UUID
     */
    public function getUUID(): UUID
    {
        $uuid = substr($this->buffer, $this->offset, 16);
        $this->offset += 16;

        return UUID::fromString($uuid);
    }

    /**
     * Encode une Position code sur 64 bits.
     * x (-33554432 to 33554431), z (-33554432 to 33554431), y (-2048 to 2047)
     * 
     * @param integer|Position $x
     * @param ?integer $y
     * @param ?integer $z
     * @return PacketSerializer $this
     */
    public function putPosition(int|Position $x, ?int $y = 0, ?int $z = 0): PacketSerializer
    {
        if ($x instanceof Position) {
            $y = $x->getY();
            $z = $x->getZ();
            $x = $x->getX();
        }

        $this->putLong(
            (($x & 0x3FFFFFF) << 38) | (($z & 0x3FFFFFF) << 12) | ($y & 0xFFF)
        );

        return $this;
    }

    /**
     * Lit une Position code sur 64 bits.
     * x (-33554432 to 33554431), z (-33554432 to 33554431), y (-2048 to 2047)
     *
     * @return Position
     * @throws \Exception
     */
    public function getPosition(): Position
    {
        $value = $this->getLong();
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
     * @return PacketSerializer $this
     * @throws \Exception
     */
    public function putUnsignedShort(int $value): PacketSerializer
    {
        if ($value < 0 || $value > 65535) {
            throw new \Exception("Valeur de short invalide");
        }
        $this->put(pack('n', $value));
        return $this;
    }

    /**
     * Lit un unsigned short.
     *
     * @return integer
     */
    public function getUnsignedShort(): int
    {
        $value = unpack('n', substr($this->buffer, $this->offset, 2))[1];
        $this->offset += 2;

        return $value;
    }

    /**
     * Encode un byte array binaire (comme utilisé par NBT ou d'autres données binaires).
     * 
     * @param string|array<int> $data
     * @return PacketSerializer $this
     */
    public function putByteArray(string|array $data): PacketSerializer
    {
        if (is_string($data)) {
            $this->putVarInt(strlen($data));
            $this->put($data);

            return $this;
        }

        $this->putVarInt(count($data));
        foreach ($data as $item) {
            $this->putByte($item);
        }

        return $this;
    }

    /**
     * Lit un byte array.
     *
     * @return array
     * @throws \Exception
     */
    public function getByteArray(): array
    {
        $length = $this->getVarInt();
        $data = substr($this->buffer, $this->offset, $length);
        $this->offset += $length;

        return array_values(unpack('C*', $data));
    }

    /**
     * Encode un unsigned byte.
     * 
     * @param integer $value
     * @return PacketSerializer $this
     */
    public function putUnsignedByte(int $value): PacketSerializer
    {
        $this->put(pack('C', $value));
        return $this;
    }

    /**
     * Lit un unsigned byte.
     *
     * @return integer
     */
    public function getUnsignedByte(): int
    {
        return ord($this->buffer[$this->offset++]);
    }

    /**
     * @param int $value
     * @return PacketSerializer $this
     */
    public function putUnsignedLong(int $value): PacketSerializer
    {
        $this->put(pack('P', $value));

        return $this;
    }

    public function putAngle(float $degrees): PacketSerializer
    {
        $degrees = fmod($degrees, 360.0);
        if ($degrees < 0) {
            $degrees += 360.0;
        }

        $encoded = (int) round(($degrees / 360.0) * 256) & 0xFF;

        $this->putByte($encoded);
        return $this;
    }

    public function putNBT(Tag $tag): PacketSerializer
    {
        $writer = (new StringWriter())
            ->setFormat(NbtFormat::JAVA_EDITION);

        $tag->writeData($writer, false);

        $this->put($writer->getStringData());
        return $this;
    }

    public function getNBytes(int $len): string
    {
        $n_bytes = substr($this->buffer, $this->offset, $len);
        $this->offset += $len;

        return $n_bytes;
    }

    public function putBitSet(BitSet $bitset): PacketSerializer
    {
        $bitCount = $bitset->getSize();
        $longCount = intdiv($bitCount + 63, 64);

        $this->putVarInt($longCount);

        for ($i = 0; $i < $longCount; $i++) {
            $value = 0;
            for ($j = 0; $j < 64; $j++) {
                $bitIndex = $i * 64 + $j;
                if ($bitIndex >= $bitCount) break;
                if ($bitset->get($bitIndex)) {
                    $value |= (1 << $j);
                }
            }

            $this->putLong($value);
        }

        return $this;
    }

    public function putObject(ProtocolEncodable $encodable): PacketSerializer
    {
        $encodable->encode($this);

        return $this;
    }
}