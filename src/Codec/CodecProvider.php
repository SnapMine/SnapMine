<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Marks a class as providing a {@see Codec} for its own serialization.
 *
 * A single declaration serves every format (NBT, JSON, and later the
 * network protocol via {@see StreamCodec::nbt()}).
 */
interface CodecProvider
{
    /**
     * @return Codec<mixed> the codec of the implementing class
     */
    public static function codec(): Codec;
}
