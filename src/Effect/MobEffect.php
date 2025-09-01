<?php

namespace SnapMine\Effect;

use SnapMine\Entity\LivingEntity;
use SnapMine\Network\Packet\Clientbound\Play\UpdateMobEffectPacket;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Network\Serializer\ProtocolEncodable;

class MobEffect implements ProtocolEncodable
{
    public function __construct(
        private MobEffectType $type,
        private int $duration,
        private int $amplifier,
        private bool $ambient = true,
        private bool $particles = true,
        private bool $icon = true,
    )
    {
    }

    public function setType(MobEffectType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return MobEffectType
     */
    public function getType(): MobEffectType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return MobEffect
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmplifier(): int
    {
        return $this->amplifier;
    }

    public function setAmplifier(int $amplifier): self
    {
        $this->amplifier = $amplifier;

        return $this;
    }

    /**
     * @param bool $ambient
     * @return MobEffect
     */
    public function setAmbient(bool $ambient): self
    {
        $this->ambient = $ambient;

        return $this;
    }

    public function hasAmbient(): bool
    {
        return $this->ambient;
    }

    public function setParticles(bool $particles): self
    {
        $this->particles = $particles;

        return $this;
    }

    public function hasParticles(): bool
    {
        return $this->particles;
    }

    public function setIcon(bool $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function hasIcon(): bool
    {
        return $this->icon;
    }

    public function isInfinite(): bool
    {
        return $this->duration === -1;
    }

    public function apply(LivingEntity $entity): void
    {
        $entity->addMobEffect($this);
    }

    public function toPacket(PacketSerializer $serializer): void
    {
        $serializer
            ->putVarInt($this->type->value)
            ->putVarInt($this->amplifier)
            ->putVarInt($this->duration);

        $flags = 0;

        if ($this->ambient)
            $flags |= 0x01;
        if ($this->particles)
            $flags |= 0x02;
        if ($this->icon)
            $flags |= 0x04;

        $serializer->putByte($flags);
    }
}