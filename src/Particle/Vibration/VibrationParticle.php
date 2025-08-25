<?php

namespace Nirbose\PhpMcServ\Particle\Vibration;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\Serializer\ProtocolEncodable;

class VibrationParticle implements ProtocolEncodable
{
    public function __construct(
        private VibrationDestination $destination,
        private int $arrivalTicks,
    )
    {
    }

    /**
     * @return int
     */
    public function getArrivalTicks(): int
    {
        return $this->arrivalTicks;
    }

    /**
     * @return VibrationDestination
     */
    public function getDestination(): VibrationDestination
    {
        return $this->destination;
    }

    public function toPacket(PacketSerializer $serializer): void
    {
        if ($this->destination instanceof BlockDestination) {
            $serializer
                ->putVarInt(0)
                ->putPosition($this->destination->getBlock()->getLocation());

        } else {
            /** @var EntityDestination $destination */
            $destination = $this->destination;

            $serializer
                ->putVarInt(1)
                ->putVarInt($destination->getEntity()->getId())
                ->putFloat(1.0); // TODO: The height of the entity's eye relative to the entity.
        }

        $serializer->putVarInt($this->arrivalTicks);
    }
}