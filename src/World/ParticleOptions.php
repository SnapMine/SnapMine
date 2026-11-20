<?php

declare(strict_types=1);

namespace SnapMine\World;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecException;
use SnapMine\Codec\Ops;
use SnapMine\Codec\Path;
use SnapMine\Codec\CodecProvider;

/**
 * Particle options of a biome (`effects.particle.options`).
 *
 * The options map always contains the particle `type`; any additional
 * parameters are preserved as a raw key -> node map so the data sent to the
 * client stays faithful whatever the particle type.
 */
final class ParticleOptions implements CodecProvider
{
    /**
     * @param array<string, mixed> $options extra parameters, without the `type` key
     */
    public function __construct(
        private readonly string $type,
        private readonly array $options = [],
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= new ParticleOptionsCodec();
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}

/**
 * @implements Codec<ParticleOptions>
 */
final class ParticleOptionsCodec implements Codec
{
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        $map = $ops->getMap($input, $path);

        if (!isset($map['type'])) {
            throw CodecException::at($path->child('type'), 'missing');
        }

        $type = $ops->getString($map['type'], $path->child('type'));

        unset($map['type']);

        return new ParticleOptions($type, $map);
    }

    /**
     * @param mixed $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        if (!$value instanceof ParticleOptions) {
            throw CodecException::at(Path::root(), 'expected ParticleOptions, got ' . get_debug_type($value));
        }

        $map = ['type' => $ops->createString($value->getType())];

        foreach ($value->getOptions() as $key => $node) {
            $map[$key] = $node;
        }

        return $ops->createMap($map);
    }
}
