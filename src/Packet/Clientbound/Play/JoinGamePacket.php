<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Play;

use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Session\Session;

class JoinGamePacket extends Packet
{
    public function getId(): int
    {
        return 0x2B;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        throw new \Exception("JoinGamePacket ne peut pas être reçu");
    }

    public function write(PacketSerializer $serializer): void
    {
        $registries = [
            'minecraft:dimension_type' => [
                'type' => 'minecraft:dimension_type',
                'default' => 'minecraft:overworld',
                'elements' => [
                    [
                        'name' => 'minecraft:overworld',
                        'id' => 0,
                        'element' => [
                            'piglin_safe' => false,
                            'natural' => true,
                            'ambient_light' => 0.0,
                            'infiniburn' => 'minecraft:infiniburn_overworld',
                            'respawn_anchor_works' => false,
                            'has_skylight' => true,
                            'bed_works' => true,
                            'effects' => 'minecraft:overworld',
                            'has_raids' => true,
                            'logical_height' => 256,
                            'coordinate_scale' => 1.0,
                            'ultrawarm' => false,
                            'height' => 384,
                            'min_y' => 0
                        ]
                    ],
                    // ajoute d'autres dimensions si besoin
                ]
            ],
            'minecraft:worldgen/biome' => [
                'type' => 'minecraft:worldgen/biome',
                'default' => 'minecraft:plains',
                'elements' => [
                    [
                        'name' => 'minecraft:plains',
                        'id' => 0,
                        'element' => [
                            'precipitation' => 'rain',
                            'depth' => 0.125,
                            'temperature' => 0.8,
                            'scale' => 0.05,
                            'downfall' => 0.4,
                            'effects' => [
                                'sky_color' => 7907327,
                                'water_fog_color' => 329011,
                                'fog_color' => 12638463,
                                'water_color' => 4159204,
                                'mood_sound' => [
                                    'sound' => 'minecraft:ambient.cave',
                                    'tick_delay' => 6000,
                                    'offset' => 2.0,
                                    'block_search_extent' => 8
                                ]
                            ],
                            'category' => 'plains',
                            'depth' => 0.125,
                            'temperature_modifier' => 'none'
                        ]
                    ],
                ]
            ],
            // tu peux ajouter d'autres registries comme minecraft:chat_type etc.
        ];


        $serializer->putInt(0); // Entity ID
        $serializer->putBool(false); // Is Hardcore
        $serializer->putRegistryData($registries); // Registries
        $serializer->putVarInt(100); // Max Playerss
        $serializer->putVarInt(10); // View Distance
        $serializer->putVarInt(10); // Simulation Distance
        $serializer->putBool(false); // Reduced Debug Info
        $serializer->putBool(true); // Enable Respawn Screen
        $serializer->putBool(false); // Do Limited Crafting
        // $serializer->putVarInt(0); // Dimension Type ID
        $serializer->putString('minecraft:overworld'); // Dimension Name
        $serializer->putLong(234345456); // Hashed seed
        $serializer->putUnsignedByte(0); // Game Mode
        $serializer->putByte(-1); // Previous Game Mode
        $serializer->putBool(false); // Is Debug
        $serializer->putBool(false); // Is Flat
        $serializer->putBool(false); // Has death location
        $serializer->putVarInt(0); // Portal cooldown
        $serializer->putVarInt(63); // Sea level
        $serializer->putBool(false); // Enforces Secure Chat
    }

    public function handle(Session $session): void
    {
    }
}
