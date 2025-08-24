<?php

namespace Nirbose\PhpMcServ\World;

use Couchbase\IndexNotFoundException;
use Nirbose\PhpMcServ\World\Chunk\Chunk;
use function React\Async\async;
use function React\Async\await;
use function React\Promise\all;

class World
{
    /** @var array<string, Region> */
    private array $regions = [];
    private string $name;

    public function __construct(string $worldFolder)
    {
        $this->name = basename($worldFolder);

        foreach (glob($worldFolder . '/region/*.mca') as $file) {
            $this->regions[basename($file, '.mca')] = new Region($file);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getChunk(int $x, int $z): ?Chunk
    {
        $regX = $x >> 5;
        $regZ = $z >> 5;
        $key = 'r.' . $regX . '.' . $regZ;

        if (isset($this->regions[$key])) {
            $region = $this->regions[$key];

            return $region->getChunk($x & 0x1F, $z & 0x1F);
        }

        return null;
    }

    /**
     * Charge en bloc une zone (coords chunk globales) en déléguant aux régions concernées.
     *
     * @return array<int, array<int, ?Chunk>>  Grille indexée [x][z] => Chunk|null
     * @throws IndexNotFoundException
     */
    public function loadArea(int $x0, int $z0, int $x1, int $z1): array
    {
        // Normalisation des bornes
        if ($x0 > $x1) { [$x0, $x1] = [$x1, $x0]; }
        if ($z0 > $z1) { [$z0, $z1] = [$z1, $z0]; }

        // floorDiv pour gérer correctement les négatifs (contrairement à intdiv qui tronque vers 0)
        $floorDiv = static function (int $a, int $b): int {
            $q = intdiv($a, $b);
            if ((($a ^ $b) < 0) && ($a % $b !== 0)) { $q--; }
            return $q;
        };

        // 1) Déterminer les régions touchées par la zone
        $rX0 = $floorDiv($x0, 32);
        $rX1 = $floorDiv($x1, 32);
        $rZ0 = $floorDiv($z0, 32);
        $rZ1 = $floorDiv($z1, 32);

        $futures = [];

        // 2) Pour chaque région existante, appeler Region::loadArea sur la sous-zone locale [0..31]
        for ($rZ = $rZ0; $rZ <= $rZ1; $rZ++) {
            for ($rX = $rX0; $rX <= $rX1; $rX++) {
                $key = 'r.' . $rX . '.' . $rZ;
                if (!isset($this->regions[$key])) {
                    continue; // pas de Region chargée pour cette clé → on ignore
                }

                $baseX = $rX << 5; // * 32
                $baseZ = $rZ << 5;

                // Sous-rectangle local à cette région (bornes 0..31)
                $lx0 = max(0, $x0 - $baseX);
                $lz0 = max(0, $z0 - $baseZ);
                $lx1 = min(31, $x1 - $baseX);
                $lz1 = min(31, $z1 - $baseZ);

                if ($lx0 > 31 || $lz0 > 31 || $lx1 < 0 || $lz1 < 0) {
                    continue; // pas d'intersection (par sécurité)
                }

                // Charge en bloc côté Region (remplit son cache interne)

                $futures[] = async(function () use ($key, $lx0, $lz0, $lx1, $lz1) {
                    return $this->regions[$key]->loadArea($lx0, $lz0, $lx1, $lz1);
                })();
            }
        }

        $chunks = await(all($futures));

        var_dump(count($chunks));
        return array_merge([], ...$chunks);
    }

}