<?php

use SnapMine\Entity\Variant\CatVariant;
use SnapMine\Entity\Variant\SpawnConditions;
use SnapMine\Registry\DamageType;
use SnapMine\Utils\Nbt;
use SnapMine\Utils\NbtJson;

it('can serialize and deserialize DamageType correctly', function () {
    $json = [
        'exhaustion' => 1.5,
        'message_id' => 'damage.fire',
        'scaling' => 'linear',
        'effects' => 'burn',
        'death_message_type' => 'fire'
    ];

    $damageType = NbtJson::fromJson($json, DamageType::class);

    expect($damageType)->toBeInstanceOf(DamageType::class)
        ->and($damageType->getExhaustion())->toBe(1.5)
        ->and($damageType->getMessageId())->toBe('damage.fire')
        ->and($damageType->getScaling())->toBe('linear')
        ->and($damageType->getEffects())->toBe('burn')
        ->and($damageType->getDeathMessageType())->toBe('fire');

    $nbt = Nbt::toNbt($damageType);

    expect($nbt)->not->toBeNull()
        ->and($nbt->get('exhaustion')->getValue())->toBe(1.5)
        ->and($nbt->get('message_id')->getValue())->toBe('damage.fire')
        ->and($nbt->get('scaling')->getValue())->toBe('linear')
        ->and($nbt->get('effects')->getValue())->toBe('burn')
        ->and($nbt->get('death_message_type')->getValue())->toBe('fire');

    $damageType2 = Nbt::fromNbt($nbt, DamageType::class);

    expect($damageType2)->toBeInstanceOf(DamageType::class)
        ->and($damageType2->getExhaustion())->toBe(1.5)
        ->and($damageType2->getMessageId())->toBe('damage.fire')
        ->and($damageType2->getScaling())->toBe('linear')
        ->and($damageType2->getEffects())->toBe('burn')
        ->and($damageType2->getDeathMessageType())->toBe('fire');
});

it('can serialize CatVariant correctly', function () {
    $json = json_decode(file_get_contents(dirname(__DIR__, 3) . '/resources/registries/cat_variant/all_black.json'), true);

    $catVariant = NbtJson::fromJson($json, CatVariant::class);

    expect($catVariant)->toBeInstanceOf(CatVariant::class)
        ->and($catVariant->getSpawnConditions())->toHaveCount(2);
});
