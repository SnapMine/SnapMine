<?php

declare(strict_types=1);

namespace SnapMine\Codec;

use Closure;

/**
 * Resolves its underlying codec on first use, which allows self-referencing
 * declarations (e.g. a text component containing more text components).
 *
 * @implements Codec<mixed>
 */
final class LazyCodec implements Codec
{
    /** @var Closure():Codec */
    private readonly Closure $factory;

    private ?Codec $resolved = null;

    /** @param Closure():Codec $factory */
    public function __construct(Closure $factory)
    {
        $this->factory = $factory;
    }

    private function codec(): Codec
    {
        return $this->resolved ??= ($this->factory)();
    }

    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        return $this->codec()->decode($ops, $input, $path);
    }

    public function encode(Ops $ops, mixed $value): mixed
    {
        return $this->codec()->encode($ops, $value);
    }
}
