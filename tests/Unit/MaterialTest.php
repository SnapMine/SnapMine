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
        expect(Material::STONE_PICKAXE->isBlock())->toBeTrue()
            ->and(Material::STONE_PICKAXE->isItem())->toBeFalse();
    });
});