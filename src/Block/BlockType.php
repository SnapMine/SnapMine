<?php

namespace Nirbose\PhpMcServ\Block;

use Nirbose\PhpMcServ\Block\Data\BlockData;
use Nirbose\PhpMcServ\Block\Type\Bed\RedBed;
use Nirbose\PhpMcServ\Block\Type\Composter;
use Nirbose\PhpMcServ\Block\Type\GenericBlockData;
use Nirbose\PhpMcServ\Material;

enum BlockType
{
    case STONE;
    case COMPOSTER;
    case RED_BED;

    /**
     * @template T of BlockData
     * @return class-string<T>
     */
    public function getBlockDataClass(): string
    {
        return match ($this) {
            self::STONE => GenericBlockData::class,
            self::COMPOSTER => Composter::class,
            self::RED_BED => RedBed::class,
        };
    }

    public function createBlockData(): ?BlockData
    {
        $class = $this->getBlockDataClass();

        if (!class_exists($class)) {
            return null;
        }

        $materialName = strtoupper($this->name);

        return new $class(...[constant(Material::class . '::' . $materialName)]);
    }
}