<?php

namespace Nirbose\PhpMcServ\Network\Serializer;

use Nirbose\PhpMcServ\Utils\UUID;

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
     * Encode un entier 16 bits en utilisant le format Little Endian.
     *
     * @param integer $value
     * @return void
     */
    public function putShort(string $value): void
    {
        $this->put(pack('v', $value));
    }

    /**
     * Lit un entier 16 bits en utilisant le format Little Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getShort(string $buffer, int &$offset): int
    {
        $value = unpack('v', substr($buffer, $offset, 2))[1];
        $offset += 2;

        return $value;
    }

    /**
     * Encode un entier 32 bits en utilisant le format Little Endian.
     *
     * @param integer $value
     * @return void
     */
    public function putInt(int $value): void
    {
        $this->put(pack('V', $value));
    }

    /**
     * Lit un entier 32 bits en utilisant le format Little Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return integer
     */
    public function getInt(string $buffer, int &$offset): int
    {
        $value = unpack('V', substr($buffer, $offset, 4))[1];
        $offset += 4;

        return $value;
    }

    /**
     * Encode un entier 64 bits en utilisant le format Little Endian.
     *
     * @param integer $value
     * @return void
     */
    public function putLong(int $value): void
    {
        $this->put(pack('P', $value));
    }

    /**
     * Lit un entier 64 bits en utilisant le format Little Endian.
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
     * Encode un float en utilisant le format Little Endian.
     *
     * @param float $value
     * @return void
     */
    public function putFloat(float $value): void
    {
        $this->put(pack('f', $value));
    }

    /**
     * Lit un float en utilisant le format Little Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return float
     */
    public function getFloat(string $buffer, int &$offset): float
    {
        $value = unpack('f', substr($buffer, $offset, 4))[1];
        $offset += 4;

        return $value;
    }

    /**
     * Encode un double en utilisant le format Little Endian.
     *
     * @param float $value
     * @return void
     */
    public function putDouble(float $value): void
    {
        $this->put(pack('d', $value));
    }

    /**
     * Lit un double en utilisant le format Little Endian.
     *
     * @param string $buffer
     * @param integer $offset
     * @return float
     */
    public function getDouble(string $buffer, int &$offset): float
    {
        $value = unpack('d', substr($buffer, $offset, 8))[1];
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
     * @param string $uuid
     * @return void
     */
    public function putUUID(string|UUID $uuid): void
    {
        if ($uuid instanceof UUID) {
            $uuid = $uuid->toString();
        }

        $this->put(pack('H*', str_replace('-', '', $uuid)));
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
     * @return array
     */
    public function getPosition(string $buffer, int &$offset): array
    {
        $value = $this->getLong($buffer, $offset);
        $x = $value >> 38;
        $y = $value << 52 >> 52;
        $z = $value << 26 >> 38;

        return [$x, $y, $z];
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
        $this->put(pack('v', $value));
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
        $value = unpack('v', substr($buffer, $offset, 2))[1];
        $offset += 2;

        if ($value < 0 || $value > 65535) {
            throw new \Exception("Valeur de short invalide");
        }

        return $value;
    }

    /**
     * Encode un byte array.
     * 
     * @param array $data
     * @return void
     */
    public function putByteArray(array $data): void
    {
        $this->put(
            pack('C*', ...$data)
        );
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

    /**
     * Encode un tag NBT en fonction de son type.
     * 
     * @param mixed $value La valeur NBT à encoder
     * @param string|null $name Le nom du tag (nullable)
     * @param int|null $type Le type NBT (si null, type sera déduit)
     * @return void
     */
    public function putNBT(mixed $value, ?string $name = null, ?int $type = null): void
    {
        if ($type === null) {
            $type = $this->getNBTType($value);
        }

        // TAG_End
        if ($type === 0) {
            $this->putByte(0);
            return;
        }

        // Écrire le type
        $this->putByte($type);

        // Écrire le nom du tag (string avec longueur VarInt)
        if ($name !== null) {
            $this->putNBTString($name);
        }

        // Écrire la valeur selon le type
        switch ($type) {
            case 1: // TAG_Byte
                $this->putByte($value);
                break;
            case 2: // TAG_Short
                $this->putShort($value);
                break;
            case 3: // TAG_Int
                $this->putInt($value);
                break;
            case 4: // TAG_Long
                $this->putLong($value);
                break;
            case 5: // TAG_Float
                $this->putFloat($value);
                break;
            case 6: // TAG_Double
                $this->putDouble($value);
                break;
            case 7: // TAG_Byte_Array
                $this->putInt(count($value));
                foreach ($value as $b) {
                    $this->putByte($b);
                }
                break;
            case 8: // TAG_String
                $this->putNBTString($value);
                break;
            case 9: // TAG_List
                // Tous les éléments doivent être du même type, on encode ce type ici
                if (empty($value)) {
                    $this->putByte(0); // TAG_End type
                    $this->putInt(0);
                } else {
                    $elemType = $this->getNBTType($value[0]);
                    $this->putByte($elemType);
                    $this->putInt(count($value));
                    foreach ($value as $elem) {
                        $this->putNBT($elem, null, $elemType);
                    }
                }
                break;
            case 10: // TAG_Compound
                foreach ($value as $k => $v) {
                    $this->putNBT($v, $k);
                }
                $this->putByte(0); // TAG_End pour terminer le compound
                break;
            case 11: // TAG_Int_Array
                $this->putInt(count($value));
                foreach ($value as $i) {
                    $this->putInt($i);
                }
                break;
            case 12: // TAG_Long_Array
                $this->putInt(count($value));
                foreach ($value as $l) {
                    $this->putLong($l);
                }
                break;
            default:
                throw new \Exception("Type NBT inconnu: $type");
        }
    }

    /**
     * Déduit le type NBT d'une valeur PHP.
     * 
     * @param mixed $value
     * @return int
     */
    private function getNBTType(mixed $value): int
    {
        if (is_int($value)) {
            // Ici on pourrait affiner selon la taille, mais par défaut TAG_Int
            return 3;
        }

        if (is_float($value)) {
            return 5; // TAG_Float
        }

        if (is_string($value)) {
            return 8; // TAG_String
        }

        if (is_array($value)) {
            // On distingue les tableaux associatifs (compound) des tableaux indexés (list)
            $keys = array_keys($value);
            $isAssoc = array_filter($keys, 'is_string') !== [];

            if ($isAssoc) {
                return 10; // TAG_Compound
            }

            return 9; // TAG_List
        }

        if (is_bool($value)) {
            return 1; // TAG_Byte avec 0 ou 1
        }

        throw new \Exception("Impossible de déterminer le type NBT pour la valeur");
    }

    public function putNBTString(string $data): void
    {
        $this->put(pack('n', strlen($data))); // longueur sur 2 octets BE
        $this->put($data);
    }
}