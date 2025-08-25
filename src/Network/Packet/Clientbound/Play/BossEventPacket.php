<?php

namespace SnapMine\Network\Packet\Clientbound\Play;

use SnapMine\BossBar\BossBar;
use SnapMine\BossBar\BossBarAction;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class BossEventPacket extends ClientboundPacket
{
    public function __construct(
        private readonly BossBarAction $action,
        private readonly BossBar       $bossBar,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putUUID($this->bossBar->getUuid())
            ->putVarInt($this->action->value);

        if ($this->action == BossBarAction::ADD) {
            $serializer->putNBT($this->bossBar->getTitle()->toNBT())
                ->putFloat($this->bossBar->getHealth())
                ->putVarInt($this->bossBar->getColor()->value)
                ->putVarInt($this->bossBar->getDivision()->value)
                ->putUnsignedByte($this->bossBar->getFlags());

        } else if ($this->action == BossBarAction::UPDATE_HEALTH) {
            $serializer->putFloat($this->bossBar->getHealth());

        } else if ($this->action == BossBarAction::UPDATE_TITLE) {
            $serializer->putNBT($this->bossBar->getTitle()->toNBT());

        } else if ($this->action == BossBarAction::UPDATE_STYLE) {
            $serializer->putVarInt($this->bossBar->getColor()->value)
                ->putVarInt($this->bossBar->getDivision()->value);

        } else if ($this->action == BossBarAction::UPDATE_FLAGS) {
            $serializer->putUnsignedByte($this->bossBar->getFlags());
        }
    }

    public function getId(): int
    {
        return 0x09;
    }
}