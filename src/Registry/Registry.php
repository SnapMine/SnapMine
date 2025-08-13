<?php

namespace Nirbose\PhpMcServ\Registry;

enum Registry: string
{
    case TRIM_MATERIAL = TrimMaterial::class;
    case TRIM_PATTERN = TrimPattern::class;

    public static function load(string $dirPath): void
    {
        foreach (self::cases() as $value) {
            $name = strtolower($value->name);

            foreach (glob($dirPath . strtolower($value->name) . '/*.json') as $entry) {
                $filename = basename($entry, ".json");
                $data = json_decode(file_get_contents($entry), true);

                $value->value::register($filename, 'minecraft:' . $name, $data);
            }
        }
    }
}