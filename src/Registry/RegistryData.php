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
    protected array|object $data;
    protected int $id;

    public static function register(string $name, string $key, array|object $data): static
    {
        $entries = &self::$entries[static::class];
        $id = count($entries ?? []);
        $instance = new static();

        $instance->key = $key;
        $instance->id = $id;
        $instance->data = $data;

        $entries[strtoupper($name)] = $instance;

        return $instance;
    }

    public static function __callStatic(string $name, array $args): static
    {
        $name = strtoupper($name);
        if (!isset(self::$entries[self::class][$name])) {
            throw new \RuntimeException("Registry data '$name' not found for " . static::class);
        }

        return self::$entries[self::class][$name];
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
        return self::$entries[self::class] ?? [];
    }
}
