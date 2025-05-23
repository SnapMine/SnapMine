<?php

namespace Nirbose\PhpMcServ\Session;

use Exception;
use Nirbose\PhpMcServ\Core\Server;
use Nirbose\PhpMcServ\Network\Connection;
use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Protocol;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Network\ServerState;
use Nirbose\PhpMcServ\Packet\Handshaking\HandshakePacket;
use Nirbose\PhpMcServ\Packet\LoginSuccessPacket;
use Nirbose\PhpMcServ\Packet\Play\JoinGamePacket;
use Nirbose\PhpMcServ\Packet\Status\PongPacket;
use Nirbose\PhpMcServ\Packet\Status\StatusResponsePacket;
use Nirbose\PhpMcServ\Utils\UUID;

class PlayerSession
{
    private Connection $conn;
    private PacketSerializer $serializer;
    private ServerState $state = ServerState::HANDSHAKING;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
        $this->serializer = new PacketSerializer();
    }

    public function sendPacket(Packet $packet): void
    {
        $serializer = new PacketSerializer();
        $serializer->putVarInt($packet->getId());
        $packet->write($serializer);

        packet_dump($packet);

        $this->conn->writePacket(
            $serializer->get()
        );
    }

    public function handle(): void
    {
        $this->handleHandshake();

        $offset = 0;
        $raw = $this->conn->readPacket();

        if ($raw === null || $raw === false) return;

        $this->serializer->getVarInt($raw, $offset); // length
        $packetId = $this->serializer->getVarInt($raw, $offset);

        var_dump($this->state->value, $packetId);
        

        $this->sendPacket(
            Protocol::PACKETS[$this->state->value][intval($packetId)]
        );
    }

    public function handleHandshake(): void
    {
        if ($this->state !== ServerState::HANDSHAKING) {
            return;
        }

        $raw = $this->conn->readPacket();

        if ($raw === null || $raw === false) {
            return;
        }

        $offset = 0;
        $serializer = new PacketSerializer();

        $handshake = new HandshakePacket();

        $handshake->read($serializer, $raw, $offset);

        switch ($handshake->nextState) {
            case 1:
                $this->state = ServerState::STATUS;
                break;
            case 2:
                $this->state = ServerState::LOGIN;
                break;
            default:
                Server::getLogger()->error("État non valide : " . $handshake->nextState);
                $this->conn->close();
                return;
        }
    }

    // public function handle(): void
    // {
    //     $raw = $this->conn->readPacket();

    //     if (!$raw) {
    //         $this->conn->close();
    //         return;
    //     }

    //     $offset = 0;
    //     $packetLen = $this->serializer->getVarInt($raw, $offset);
    //     $packetId = $this->serializer->getVarInt($raw, $offset);

    //     $protocol = $this->serializer->getVarInt($raw, $offset);
    //     $addrLen = $this->serializer->getVarInt($raw, $offset);
    //     $addr = substr($raw, $offset, $addrLen);
    //     $offset += $addrLen;
    //     $port = unpack("n", substr($raw, $offset, 2))[1];
    //     $offset += 2;
    //     $nextState = ord($raw[$offset++]);

    //     if ($this->state === ServerState::CONFIGURATION) {
    //         $this->handleConfig();
    //         return;
    //     }

    //     echo "Verif packet : " . bin2hex($raw) . "\n";

    //     if ($nextState === 1) {
    //         $this->handleStatus();
    //     } elseif ($nextState === 2) {
    //         $this->handleLogin();
    //     } else {
    //         Server::getLogger()->error("État non valide : $nextState");
    //         $this->conn->close();
    //     }
    // }

    private function handleStatus(): void
    {
        $this->conn->readPacket();

        $json = json_encode([
            "version" => ["name" => Protocol::PROTOCOL_NAME, "protocol" => Protocol::PROTOCOL_VERSION],
            "players" => [
                "max" => 20,
                "online" => 1,
                "sample" => [["name" => "Yoooo", "id" => "00000000-0000-0000-0000-000000000000"]],
            ],
            "description" => ["text" => "§aServeur PHP prêt !"],
        ]);

        $this->sendPacket(
            new StatusResponsePacket($json)
        );

        $ping = $this->conn->readPacket(512);

        if (!$ping) {
            Server::getLogger()->error("Aucun paquet ping reçu");
            $this->conn->close();
            return;
        }

        $off = 0;
        try {
            $this->serializer->getVarInt($ping, $off);
            $pingId = $this->serializer->getVarInt($ping, $off);
            $payload = substr($ping, $off);
        } catch (Exception $e) {
            Server::getLogger()->error("Erreur VarInt ping : " . $e->getMessage());
            $this->conn->close();
            return;
        }

        if ($pingId === 0x01) {
            $this->sendPacket(
                new PongPacket(intval($payload))
            );
        }

        $this->conn->close();
    }

    private function handleLogin(): void
    {
        $data = $this->conn->readPacket();

        if (!$data) {
            Server::getLogger()->error("Aucun paquet de login reçu");
            $this->conn->close();
            return;
        }

        $offset = 0;

        $this->serializer->getVarInt($data, $offset); // length
        $packetId = $this->serializer->getVarInt($data, $offset);

        if ($packetId !== 0x00) {
            Server::getLogger()->error("Paquet de login non valide : $packetId");
            $this->conn->close();
            return;
        }

        $nameLen = $this->serializer->getVarInt($data, $offset);
        $name = substr($data, $offset, $nameLen);

        $uuid = UUID::generateOffline($name);
        $name = substr($name, 0, 16); // Tronquer le nom si besoin

        $this->sendPacket(
            new LoginSuccessPacket($name, $uuid)
        );

        Server::getLogger()->info("Login success : $name");

        $this->state = ServerState::CONFIGURATION;

        $this->sendPacket(
            new JoinGamePacket()
        );

        $this->conn->readPacket(2);
        $this->conn->readPacket(4096);
    }

    private function handleConfig(): void
    {

    }
}
