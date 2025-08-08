<?php

namespace Nirbose\PhpMcServ\Entity\Metadata;

use Aternos\Nbt\IO\Writer\StringWriter;
use Aternos\Nbt\NbtFormat;
use BackedEnum;
use Nirbose\PhpMcServ\Component\TextComponent;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class MetadataEntry
{
    public function __construct(
        public MetadataType $type,
        public mixed        $value
    )
    {
    }

    public function getType(): MetadataType
    {
        return $this->type;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function serialize(): string
    {
        $serializer = new PacketSerializer("");

        $serializer->putVarInt($this->type->value);

        if (str_contains($this->type->name, "OPTIONAL")) {
            if (is_null($this->type->value)) {
                $serializer->putBool(false);

                return $serializer->get();
            }

            $serializer->putBool(true);
        }

        $serializer = match ($this->type) {
            MetadataType::BYTE => $serializer->putByte($this->value),
            MetadataType::VAR_INT,
            MetadataType::DIRECTION,
            MetadataType::BLOCK_STATE,
            MetadataType::OPTIONAL_BLOCK_STATE,
            MetadataType::OPTIONAL_VAR_INT,
            MetadataType::POSE,
            MetadataType::CAR_VARIANT,
            MetadataType::COW_VARIANT,
            MetadataType::WOLF_VARIANT,
            MetadataType::WOLF_SOUND_VARIANT,
            MetadataType::VAR_LONG,
            MetadataType::FROG_VARIANT,
            MetadataType::PIG_VARIANT,
            MetadataType::CHICKEN_VARIANT,
            MetadataType::SNIFFER_STATE,
            MetadataType::ARMADILLO_STATE => $serializer->putVarInt($this->value instanceof BackedEnum ? $this->value->value : $this->value),
            MetadataType::FLOAT => $serializer->putFloat($this->value),
            MetadataType::STRING => $serializer->putString($this->value),
            MetadataType::TEXT_COMPONENT,
            MetadataType::OPTIONAL_TEXT_COMPONENT => $this->serializeNBT($serializer),
            MetadataType::SLOT => throw new \Exception('To be implemented'),
            MetadataType::BOOLEAN => $serializer->putBool($this->value),
            MetadataType::ROTATIONS => throw new \Exception('To be implemented'),
            MetadataType::POSITION,
            MetadataType::OPTIONAL_POSITION => $serializer->putPosition($this->value),
            MetadataType::OPTIONAL_LIVING_ENTITY_REFERENCE => throw new \Exception('To be implemented'),
            MetadataType::NBT => $this->serializeNBT($serializer),
            MetadataType::PARTICLE => throw new \Exception('To be implemented'),
            MetadataType::PARTICLES => throw new \Exception('To be implemented'),
            MetadataType::VILLAGER_DATA => throw new \Exception('To be implemented'),
            MetadataType::OPTIONAL_GLOBAL_POSITION => throw new \Exception('To be implemented'),
            MetadataType::PAINTING_VARIANT => throw new \Exception('To be implemented'),
            MetadataType::VECTOR3 => throw new \Exception('To be implemented'),
            MetadataType::QUATERNION => throw new \Exception('To be implemented'),

        };

        return $serializer->get();
    }

    private function serializeNBT(PacketSerializer $serializer): PacketSerializer
    {
        if ($this->value instanceof TextComponent) {
            $nbt = $this->value->toNBT();
        } else {
            $nbt = $this->value;
        }

        $writer = (new StringWriter())
            ->setFormat(NbtFormat::JAVA_EDITION);
        $nbt->writeData($writer, false);

        $serializer->put($writer->getStringData());

        return $serializer;
    }
}