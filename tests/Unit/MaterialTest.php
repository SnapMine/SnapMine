<?php

use Nirbose\PhpMcServ\Material;

describe('Test material', function () {
    it('Test air material', function () {
        expect(Material::AIR->isAir())->toBeTrue()
            ->and(Material::AIR->isBlock())->toBeTrue();
    });

    it('Test item material', function () {
        expect(Material::DIAMOND_PICKAXE->isBlock())->toBeFalse()
            ->and(Material::DIAMOND_PICKAXE->isItem())->toBeTrue();
    });

    it('Test block material', function () {
        expect(Material::STONE->isBlock())->toBeTrue()
            ->and(Material::STONE->isItem())->toBeFalse();
    });

    it('Test get itemId and blockId', function () {
        expect(Material::NOTE_BLOCK->getItemId())->toBe(711)
            ->and(Material::NOTE_BLOCK->getBlockId())->toBe(581);
    });
});