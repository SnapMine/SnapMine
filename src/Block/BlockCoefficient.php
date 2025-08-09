<?php

namespace Nirbose\PhpMcServ\Block;

class BlockCoefficient
{
    private static array $blocks = [];

    public static function load(string $filePath): void
    {
        $content = file_get_contents($filePath);

        self::$blocks = json_decode($content, true);
    }

    public static function getCoefficient(string $key): array
    {
        $key = strtolower($key);

        if (array_key_exists($key, self::$blocks)) {
            return self::$blocks[$key];
        }

        return [];
    }
}