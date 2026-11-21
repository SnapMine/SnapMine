<?php

declare(strict_types=1);

use SnapMine\Codec\Io\JsonIO;
use SnapMine\Codec\Io\NbtIO;
use SnapMine\Entity\Variant\CatVariant;
use SnapMine\Registry\DamageType;

it('can decode a DamageType from JSON data', function () {
    $json = [
        'exhaustion' => 1.5,
        'message_id' => 'damage.fire',
        'scaling' => 'linear',
        'effects' => 'burn',
        'death_message_type' => 'fire',
    ];

    $damageType = JsonIO::decode(DamageType::codec(), $json);

    expect($damageType)->toBeInstanceOf(DamageType::class)
        ->and($damageType->getExhaustion())->toBe(1.5)
        ->and($damageType->getMessageId())->toBe('damage.fire')
        ->and($damageType->getScaling())->toBe('linear')
        ->and($damageType->getEffects())->toBe('burn')
        ->and($damageType->getDeathMessageType())->toBe('fire');
});

it('applies defaults and omits null optional fields', function () {
    $damageType = JsonIO::decode(DamageType::codec(), [
        'message_id' => 'arrow',
        'scaling' => 'when_caused_by_living_non_player',
    ]);

    expect($damageType->getExhaustion())->toBe(0.0)
        ->and($damageType->getEffects())->toBeNull()
        ->and($damageType->getDeathMessageType())->toBeNull();

    $encoded = JsonIO::encode(DamageType::codec(), $damageType);

    expect($encoded)->toBe([
        'exhaustion' => 0.0,
        'message_id' => 'arrow',
        'scaling' => 'when_caused_by_living_non_player',
    ]);
});

it('can round-trip a DamageType through NBT', function () {
    $damageType = JsonIO::decode(DamageType::codec(), [
        'exhaustion' => 1.5,
        'message_id' => 'damage.fire',
        'scaling' => 'linear',
        'effects' => 'burn',
        'death_message_type' => 'fire',
    ]);

    $tag = NbtIO::toTag(DamageType::codec(), $damageType);

    expect($tag->get('exhaustion')->getValue())->toBe(1.5)
        ->and($tag->get('message_id')->getValue())->toBe('damage.fire')
        ->and($tag->get('scaling')->getValue())->toBe('linear')
        ->and($tag->get('effects')->getValue())->toBe('burn')
        ->and($tag->get('death_message_type')->getValue())->toBe('fire');

    $damageType2 = NbtIO::fromTag(DamageType::codec(), $tag);

    expect($damageType2)->toBeInstanceOf(DamageType::class)
        ->and($damageType2->getExhaustion())->toBe(1.5)
        ->and($damageType2->getMessageId())->toBe('damage.fire')
        ->and($damageType2->getScaling())->toBe('linear')
        ->and($damageType2->getEffects())->toBe('burn')
        ->and($damageType2->getDeathMessageType())->toBe('fire');
});

it('can serialize CatVariant correctly', function () {
    $json = json_decode(file_get_contents(dirname(__DIR__, 3) . '/resources/registries/cat_variant/all_black.json'), true);

    $catVariant = JsonIO::decode(CatVariant::codec(), $json);

    expect($catVariant)->toBeInstanceOf(CatVariant::class)
        ->and($catVariant->getSpawnConditions())->toHaveCount(2)
        ->and($catVariant->getSpawnConditions()[0]->getCondition()->getType())->toBe('minecraft:structure')
        ->and($catVariant->getSpawnConditions()[1]->getCondition()->getRange()?->getMin())->toBe(0.9);
});
