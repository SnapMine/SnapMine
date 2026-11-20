<?php

declare(strict_types=1);

use SnapMine\Codec\Io\JsonIO;
use SnapMine\Registry\Registry;
use SnapMine\Registry\RegistryData;

/**
 * Fidelity test: every registry JSON file in resources/ must decode through
 * its codec and re-encode to exactly the same JSON structure. This proves
 * the codec declarations are faithful to the vanilla data.
 */
it('round-trips every registry entry through its codec', function () {
    $resourceDir = dirname(__DIR__, 3) . '/resources/registries';

    $count = 0;

    foreach (Registry::cases() as $registry) {
        $class = $registry->value;

        $pattern = str_contains($registry->name, '__')
            ? $resourceDir . '/' . strtolower(implode('/', explode('__', $registry->name))) . '/*.json'
            : $resourceDir . '/' . strtolower($registry->name) . '/*.json';

        foreach (glob($pattern) as $file) {
            $original = json_decode(file_get_contents($file), true);
            $filename = basename($file, '.json');

            $entry = JsonIO::decode($class::codec(), $original);
            expect($entry)->toBeInstanceOf(RegistryData::class);

            $reEncoded = JsonIO::encode($class::codec(), $entry);

            expect(sortKeys($reEncoded))->toBe(
                sortKeys($original),
                "Registry entry $filename ({$registry->name}) does not round-trip faithfully:\n" .
                    json_encode($original, JSON_PRETTY_PRINT) . "\nvs\n" .
                    json_encode($reEncoded, JSON_PRETTY_PRINT),
            );

            $count++;
        }
    }

    expect($count)->toBeGreaterThan(100);
});

/**
 * Recursively sorts map keys so that JSON key order (not significant) does
 * not break the comparison.
 */
function sortKeys(mixed $data): mixed
{
    if (!is_array($data)) {
        return $data;
    }

    if (array_is_list($data)) {
        return array_map(sortKeys(...), $data);
    }

    ksort($data);

    return array_map(sortKeys(...), $data);
}
