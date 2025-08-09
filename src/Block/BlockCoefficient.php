<?php

namespace Nirbose\PhpMcServ\Block;

class BlockCoefficient
{
    private static array $blocks = [];

    public static function load(string $filePath)
    {
        $content = file_get_contents($filePath);

        $blocks = json_decode($content, true);
        foreach ($blocks as $key => $block) {
            self::$blocks[$key] = $block['coef'];
        }
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