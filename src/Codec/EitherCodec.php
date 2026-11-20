<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Tries each alternative codec in order, until one succeeds.
 *
 * Decode: the first codec whose `decode` succeeds wins. Encode: the first
 * codec whose `encode` succeeds wins. Use for genuinely multi-typed fields
 * (e.g. `monster_spawn_light_level` which is either an int or a record).
 *
 * @implements Codec<mixed>
 */
final class EitherCodec implements Codec
{
    /** @var Codec[] */
    private readonly array $alternatives;

    public function __construct(Codec ...$alternatives)
    {
        $this->alternatives = array_values($alternatives);
    }

    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        $lastError = null;

        foreach ($this->alternatives as $alternative) {
            try {
                return $alternative->decode($ops, $input, $path);
            } catch (CodecException $e) {
                $lastError = $e;
            }
        }

        if ($lastError !== null) {
            throw $lastError;
        }

        throw CodecException::at($path, 'no alternative could decode this value');
    }

    public function encode(Ops $ops, mixed $value): mixed
    {
        $lastError = null;

        foreach ($this->alternatives as $alternative) {
            try {
                return $alternative->encode($ops, $value);
            } catch (CodecException $e) {
                $lastError = $e;
            }
        }

        if ($lastError !== null) {
            throw $lastError;
        }

        throw CodecException::at(Path::root(), 'no alternative could encode this value');
    }
}
