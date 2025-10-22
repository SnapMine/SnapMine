<?php

namespace SnapMine\Registry;

use SnapMine\Keyed;

/**
 * @template T of RegistryData
 */
abstract class RegistryData implements Keyed
{
    /** @var array<class-string<T>, array<string, T>> */
    protected static array $entries = [];

    protected string $key;
    protected int $id;

    /**
     * @param string $name
     * @param string $key
     * @param T $instance
     * @return T
     */
    public static function register(string $name, string $key, $instance)
    {
        $entries = &self::$entries[static::class];
        $id = count($entries);

        $instance->key = $key;
        $instance->id = $id;

        $entries[strtoupper($name)] = $instance;

        return $instance;
    }

    public static function __callStatic(string $name, array $args): static
    {
        $name = strtoupper($name);
        if (!isset(self::$entries[static::class][$name])) {
            throw new \RuntimeException("Registry data '$name' not found for " . static::class);
        }

        return self::$entries[static::class][$name];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public static function getEntries(): array
    {
        return self::$entries[static::class] ?? [];
    }
}
