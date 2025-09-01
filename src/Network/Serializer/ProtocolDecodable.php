<?php

namespace SnapMine\Network\Serializer;

/**
 * @template T
 */
interface ProtocolDecodable
{
    /**
     * @param PacketSerializer $serializer
     * @return self<T>
     */
    public static function decode(PacketSerializer $serializer): self;
}