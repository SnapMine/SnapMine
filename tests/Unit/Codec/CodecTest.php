<?php

declare(strict_types=1);

use SnapMine\Codec\Codec;
use Tests\Unit\Codec\Support\BlockStates;
use Tests\Unit\Codec\Support\ChunkRoot;
use Tests\Unit\Codec\Support\PaletteEntry;
use Tests\Unit\Codec\Support\Player;
use Tests\Unit\Codec\Support\Section;

use SnapMine\Codec\Codecs;
use SnapMine\Codec\NbtOps;
use SnapMine\Codec\Path;
use SnapMine\Codec\CodecException;
use SnapMine\Codec\Io\NbtIO;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\IntTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;

function dencode(Codec $codec, mixed $value): mixed
{
    return $codec->decode(NbtOps::get(), $codec->encode(NbtOps::get(), $value), Path::root());
}

function intTag(int $value): IntTag
{
    return (new IntTag())->setValue($value);
}

function strTag(string $value): StringTag
{
    return (new StringTag())->setValue($value);
}

it('round-trips an integer through the NBT format', function () {
    expect(dencode(Codecs::int(), 42))->toBe(42);
});

it('round-trips a long through the NBT format', function () {
    $value = 9_000_000_000_000_000_000;
    expect(dencode(Codecs::long(), $value))->toBe($value);
});

it('round-trips a float and a double', function () {
    expect(dencode(Codecs::float(), 1.5))->toBe(1.5);
    expect(dencode(Codecs::double(), 2.25))->toBe(2.25);
});

it('round-trips a boolean as a byte tag', function () {
    expect(dencode(Codecs::bool(), true))->toBe(true);
    expect(dencode(Codecs::bool(), false))->toBe(false);
});

it('round-trips a string', function () {
    expect(dencode(Codecs::string(), 'minecraft:stone'))->toBe('minecraft:stone');
});

it('round-trips a long array', function () {
    $value = [1, 2, 3, PHP_INT_MAX, -1];
    expect(dencode(Codecs::longArray(), $value))->toBe($value);
});

it('round-trips a list of elements', function () {
    $codec = Codecs::listOf(Codecs::string());
    expect(dencode($codec, ['a', 'b', 'c']))->toBe(['a', 'b', 'c']);
});

it('round-trips a map of values', function () {
    $codec = Codecs::mapOf(Codecs::int());
    expect(dencode($codec, ['x' => 1, 'y' => 2]))->toBe(['x' => 1, 'y' => 2]);
});

it('round-trips an optional value', function () {
    $codec = Codecs::optional(Codecs::string());
    expect(dencode($codec, 'hello'))->toBe('hello');
    expect(dencode($codec, null))->toBeNull();
});

it('round-trips through an xmap transformation', function () {
    $codec = Codecs::xmap(
        Codecs::string(),
        fn (int $n): string => (string) $n,
        fn (string $s): int => (int) $s,
    );

    expect(dencode($codec, 15))->toBe(15);
});

it('round-trips a whole record', function () {
    $player = new Player('Steve', 'Builders', 19.5, true, ['diamond', 'oak_plank']);

    $decoded = dencode(Player::codec(), $player);

    expect($decoded)->toBeInstanceOf(Player::class)
        ->and($decoded->name)->toBe('Steve')
        ->and($decoded->guild)->toBe('Builders')
        ->and($decoded->health)->toBe(19.5)
        ->and($decoded->vip)->toBeTrue()
        ->and($decoded->inventory)->toBe(['diamond', 'oak_plank']);
});

it('omits null optional fields while encoding', function () {
    $player = new Player('Alex', null, 20.0, false, []);

    $tag = NbtIO::toTag(Player::codec(), $player);

    expect($tag->get('guild'))->toBeNull()
        ->and($tag->get('name'))->not->toBeNull();
});

it('writes the default health when decoding a record without it', function () {
    $tag = new CompoundTag();
    $tag->set('name', strTag('Notch'));
    $tag->set('vip', intTag(1));
    $tag->set('inventory', new ListTag());

    $player = NbtIO::fromTag(Player::codec(), $tag);

    expect($player->health)->toBe(20.0);
});

it('throws a precise error when a required field is missing', function () {
    $tag = new CompoundTag();
    $tag->set('guild', strTag('mystery'));

    try {
        NbtIO::fromTag(Player::codec(), $tag);
        $this->fail('Expected CodecException');
    } catch (CodecException $e) {
        expect($e->getPath()->toString())->toBe('name');
    }
});

it('reports a deep, precise path through nested structures', function () {
    $root = new ChunkRoot([
        new Section(new BlockStates([new PaletteEntry('minecraft:stone')])),
        new Section(new BlockStates([new PaletteEntry('minecraft:air')])),
        new Section(new BlockStates([])),
        new Section(new BlockStates([
            new PaletteEntry('minecraft:stone'),
            new PaletteEntry('minecraft:air'),
            new PaletteEntry('minecraft:air'),
        ])),
    ]);

    $tag = NbtIO::toTag(ChunkRoot::codec(), $root);

    /** @var ListTag $sections */
    $sections = $tag->get('sections');
    /** @var CompoundTag $third */
    $third = $sections[3];
    /** @var CompoundTag $blockStates */
    $blockStates = $third->get('block_states');
    /** @var ListTag $palette */
    $palette = $blockStates->get('palette');
    $palette[2]->delete('Name');

    try {
        NbtIO::fromTag(ChunkRoot::codec(), $tag);
        $this->fail('Expected CodecException');
    } catch (CodecException $e) {
        expect($e->getMessage())->toBe('sections[3].block_states.palette[2].Name: missing');
    }
});

it('round-trips an NBT file through gzip compression', function () {
    $file = tempnam(sys_get_temp_dir(), 'nbt_') . '.dat';
    $player = new Player('Herobrine', null, 20.0, false, ['bedrock']);

    NbtIO::writeFile($file, NbtIO::toTag(Player::codec(), $player), NbtIO::GZIP);
    $tag = NbtIO::readFile($file);

    $decoded = NbtIO::fromTag(Player::codec(), $tag);

    expect($decoded->name)->toBe('Herobrine')
        ->and($decoded->inventory)->toBe(['bedrock']);

    unlink($file);
});