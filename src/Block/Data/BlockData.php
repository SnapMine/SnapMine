<?php

namespace SnapMine\Block\Data;

use SnapMine\Block\Block;
use SnapMine\Material;
use SnapMine\Network\Packet\Clientbound\Play\BlockUpdatePacket;

class BlockData
{

    public function __construct(
        private Material $material,
    )
    {
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function computedId(array $data = []): int
    {
        $traitHandlers = [
            Age::class => fn($obj, &$data) => $data['age'] = $obj->getAge(),
            Axis::class => fn($obj, &$data) => $data['axis'] = $obj->getAxis(),
            Attached::class => fn($obj, &$data) => $data['attached'] = $obj->isAttached(),
            FaceAttachable::class => fn($obj, &$data) => $data['face'] = $obj->getAttachedFace(),
            Facing::class => fn($obj, &$data) => $data['facing'] = $obj->getFacing(),
            Level::class => fn($obj, &$data) => $data['level'] = $obj->getLevel(),
            Lightable::class => fn($obj, &$data) => $data['lit'] = $obj->isLit(),
            MultipleFacing::class => function ($obj, &$data) {
                foreach ($obj->getAllowedFaces() as $face) {
                    $data[$face->value] = $obj->hasFace($face);
                }
            },
            Openable::class => fn($obj, &$data) => $data['open'] = $obj->isOpen(),
            Powerable::class => fn($obj, &$data) => $data['powered'] = $obj->isPowered(),
            Rotatable::class => fn($obj, &$data) => $data['rotation'] = $obj->getRotation(),
            Waterlogged::class => fn($obj, &$data) => $data['waterlogged'] = $obj->isWaterlogged(),
            Type::class => fn($obj, &$data) => $data['type'] = $obj->getType(),
            Half::class => fn($obj, &$data) => $data['half'] = $obj->getHalf(),
            Orientable::class => fn($obj, &$data) => $data['orientation'] = $obj->getOrientation(),
            Triggered::class => fn($obj, &$data) => $data['triggered'] = $obj->isTriggered(),
            Drag::class => fn($obj, &$data) => $data['drag'] = $obj->isDrag(),
            Dusted::class => fn($obj, &$data) => $data['dusted'] = $obj->getDustingProgress(),
            Hatch::class => fn($obj, &$data) => $data['hatch'] = $obj->getHatch(),
            Layers::class => fn($obj, &$data) => $data['layers'] = $obj->getLayers(),
            Distance::class => fn($obj, &$data) => $data['distance'] = $obj->getDistance(),
            Hanging::class => fn($obj, &$data) => $data['hanging'] = $obj->isHanging(),
            Ominous::class => fn($obj, &$data) => $data['ominous'] = $obj->isOminous(),
            Power::class => fn($obj, &$data) => $data['power'] = $obj->getPower(),
        ];

        $traits = class_uses($this);

        foreach ($traitHandlers as $trait => $handler) {
            if (in_array($trait, $traits, true)) {
                $handler($this, $data);
            }
        }

        return server()->getBlockStateLoader()
            ->getBlockStateId($this->getMaterial(), $data);
    }

    public function update(Block $block): void
    {
        $block->getChunk()->setBlock($block->getLocation(), $block);

        server()->broadcastPacket(
            new BlockUpdatePacket($block->getLocation(), $block)
        );
    }
}