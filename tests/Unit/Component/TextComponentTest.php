<?php

declare(strict_types=1);

use Aternos\Nbt\IO\Reader\StringReader;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use SnapMine\Component\TextComponent;
use SnapMine\Codec\NbtOps;
use SnapMine\Codec\Path;
use SnapMine\Network\Serializer\PacketSerializer;
use SnapMine\Utils\DyeColor;

function readUnnamedRoot(string $bytes): CompoundTag
{
    $reader = new StringReader($bytes, NbtFormat::JAVA_EDITION);

    // Network NBT: the root type byte is present, but the root has no name
    // (Tag::read() only reads name + content, not the type byte)
    $reader->read(1);

    /** @var CompoundTag $tag */
    $tag = (new CompoundTag())->read($reader, false);

    return $tag;
}

it('round-trips a plain text component through the NBT codec', function () {
    $codec = TextComponent::codec();
    $component = TextComponent::text('No Worlds found.');

    $decoded = $codec->decode(NbtOps::get(), $codec->encode(NbtOps::get(), $component), Path::root());

    expect($decoded)->toBeInstanceOf(TextComponent::class)
        ->and($decoded->getText())->toBe('No Worlds found.')
        ->and($decoded->getTranslate())->toBeNull();
});

it('round-trips a styled text component with children', function () {
    $component = TextComponent::text('Hello')
        ->color(DyeColor::RED)
        ->bold(true)
        ->italic(false)
        ->append(TextComponent::text(' world')->underline(true));

    $codec = TextComponent::codec();
    $decoded = $codec->decode(NbtOps::get(), $codec->encode(NbtOps::get(), $component), Path::root());

    expect($decoded->getText())->toBe('Hello')
        ->and($decoded->getColor())->toBe('red')
        ->and($decoded->isBold())->toBeTrue()
        ->and($decoded->isItalic())->toBeFalse()
        ->and($decoded->getChildren())->toHaveCount(1)
        ->and($decoded->getChildren()[0]->getText())->toBe(' world')
        ->and($decoded->getChildren()[0]->isUnderline())->toBeTrue();
});

it('round-trips a translatable text component', function () {
    $component = TextComponent::translatable('multiplayer.disconnect.server_full');

    $codec = TextComponent::codec();
    $decoded = $codec->decode(NbtOps::get(), $codec->encode(NbtOps::get(), $component), Path::root());

    expect($decoded->getTranslate())->toBe('multiplayer.disconnect.server_full')
        ->and($decoded->getText())->toBeNull();
});

it('encodes to an NBT compound with a text field', function () {
    $component = TextComponent::text('No Worlds found.');
    $tag = \SnapMine\Codec\Io\NbtIO::toTag($component::codec(), $component);

    expect($tag)->toBeInstanceOf(CompoundTag::class)
        ->and($tag->getString('text')?->getValue())->toBe('No Worlds found.');
});

it('serializes to network NBT: unnamed root compound, no trailing bytes', function () {
    $component = TextComponent::text('Hi');
    $tag = \SnapMine\Codec\Io\NbtIO::toTag($component::codec(), $component);

    $serializer = new PacketSerializer('', 0);
    $serializer->putNBT($tag);
    $bytes = $serializer->get();

    // Network NBT starts with the compound type (0x0A), NOT a root name
    expect($bytes[0])->toBe(chr(0x0A))
        // ...so the second byte is already the first child's tag type
        ->and($bytes[1])->toBe(chr(0x08));

    // Reparsing the written bytes must consume everything: leftover bytes
    // is exactly what makes the vanilla client throw
    // "was larger than I expected, found N bytes extra"
    $reader = new StringReader($bytes, NbtFormat::JAVA_EDITION);
    $reader->read(1);
    (new CompoundTag())->read($reader, false);

    expect($reader->eof())->toBeTrue();
});

it('writes strings as short-length-prefixed UTF-8 inside NBT', function () {
    $component = TextComponent::text('AB');
    $tag = \SnapMine\Codec\Io\NbtIO::toTag($component::codec(), $component);

    $serializer = new PacketSerializer('', 0);
    $serializer->putNBT($tag);

    // 0x0A root compound, 0x08 string child, name "text" (4 bytes),
    // value length 0x0002, payload "AB", 0x00 end tag
    expect(bin2hex($serializer->get()))->toBe('0a080004746578740002414200');
});
