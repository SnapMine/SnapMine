<?php

namespace Nirbose\PhpMcServ\Session;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Protocol;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;

class Session
{
    public string $uuid;
    public string $username;
    public ServerState $state;
    public $socket;
    public string $buffer = '';
    
    public function __construct($socket) {
        $this->socket = $socket;
        $this->state = ServerState::HANDSHAKE;
    }

    public function sendPacket(Packet $packet): void {
        $serializer = new PacketSerializer();
    
        $serializer->putVarInt($packet->getId());
        $packet->write($serializer);

        $data = $serializer->get();

        $serializer = new PacketSerializer();

        $serializer->putVarInt(strlen($data));
        $length = $serializer->get();

        echo "Sending packet ID: {$packet->getId()} with data: " . bin2hex($length . $data) . "\n";

        socket_write($this->socket, $length . $data);
    }

    public function close(): void {
        socket_close($this->socket);
    }

    public function handle(): void {
        $offset = 0;

        try {
            while (strlen($this->buffer) > $offset) {
                $serializer = new PacketSerializer();

                $packetLength = $serializer->getVarInt($this->buffer, $offset);

                if (strlen($this->buffer) < $offset + $packetLength) break;

                $packetId = $serializer->getVarInt($this->buffer, $offset);

                $packetMap = Protocol::PACKETS[$this->state->value] ?? [];
                $packetClass = $packetMap[$packetId] ?? null;

                if ($packetClass === null) {
                    throw new \Exception("Paquet inconnu ID=$packetId dans l'état {$this->state->name}");
                }

                $packet = new $packetClass();
                $packet->read($serializer, $this->buffer, $offset);
                $packet->handle($this);
            }

            $this->buffer = substr($this->buffer, $offset);
        } catch (\Exception $e) {
            echo "Erreur: " . $e->getMessage() . "\n";
            $this->close();
        }
    }
}