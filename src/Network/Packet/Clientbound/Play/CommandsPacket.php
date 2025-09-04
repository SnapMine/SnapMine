<?php

namespace SnapMine\Network\Packet\Clientbound\Play;


use SnapMine\Command\CommandManager;
use SnapMine\Network\Packet\Clientbound\ClientboundPacket;
use SnapMine\Network\Serializer\PacketSerializer;

class CommandsPacket extends ClientboundPacket
{
    public function __construct(
        private readonly CommandManager $commandManager,
    )
    {
    }

    public function write(PacketSerializer $serializer): void
    {
        $nodes = $this->commandManager->getNodes();

        foreach ($nodes as $node) {
            var_dump($node->getIndex());
        }

        $serializer->putVarInt(count($nodes) + 1);

        foreach ($nodes as $node) {
            $node->encode($serializer);
        }

        $serializer->putByte(0)->putVarInt(count($this->commandManager->getCommands()));
        foreach ($this->commandManager->getCommands() as $command) {
            $serializer->putVarInt($command->getRoot()->getIndex());
        }

        $serializer->putVarInt(count($nodes));
    }

    public function getId(): int
    {
        return 0x10;
    }
}