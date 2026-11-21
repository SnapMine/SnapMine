<?php

declare(strict_types=1);

namespace SnapMine\Codec\Io;

use Aternos\Nbt\IO\Reader\GZipCompressedStringReader;
use Aternos\Nbt\IO\Reader\Reader;
use Aternos\Nbt\IO\Reader\StringReader;
use Aternos\Nbt\IO\Reader\ZLibCompressedStringReader;
use Aternos\Nbt\IO\Writer\StringWriter;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\Tag;
use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecException;
use SnapMine\Codec\NbtOps;
use SnapMine\Codec\Path;

/**
 * Facade to read and write NBT files (level.dat, region chunks, ...) and to
 * bridge between {@see Codec}s and {@see Aternos\Nbt} tags.
 */
final class NbtIO
{
    public const NONE = 0;
    public const GZIP = 1;
    public const ZLIB = 2;

    /**
     * Decode a {@see CompoundTag} from a value using its {@see Codec}.
     *
     * @template T
     * @param Codec<T> $codec
     * @return T
     */
    public static function fromTag(Codec $codec, Tag $tag): mixed
    {
        return $codec->decode(NbtOps::get(), $tag, Path::root());
    }

    /**
     * Encode a value into a {@see CompoundTag} using its {@see Codec}.
     *
     * @template T
     * @param Codec<T> $codec
     * @param T $value
     */
    public static function toTag(Codec $codec, mixed $value): Tag
    {
        $tag = $codec->encode(NbtOps::get(), $value);

        if ($tag instanceof CompoundTag) {
            return $tag;
        }

        if ($tag instanceof Tag) {
            $wrapped = new CompoundTag();
            $wrapped->set('value', $tag);

            return $wrapped;
        }

        throw CodecException::at(Path::root(), 'codec did not encode to an NBT tag');
    }

    /**
     * Read a whole NBT file (compression is auto-detected).
     *
     * @param int $format one of {@see NbtFormat}
     */
    public static function readFile(string $path, int $format = NbtFormat::JAVA_EDITION): CompoundTag
    {
        $data = @file_get_contents($path);
        if ($data === false) {
            throw new \RuntimeException("Cannot read NBT file: {$path}");
        }

        $tag = self::fromBytes($data, $format);

        return $tag;
    }

    /**
     * Write a {@see CompoundTag} to a file with the given compression.
     *
     * @param int $compression one of {@see NbtIO} compression constants
     */
    public static function writeFile(string $path, CompoundTag $tag, int $compression = self::NONE, int $format = NbtFormat::JAVA_EDITION): void
    {
        $directory = \dirname($path);
        if (!is_dir($directory)) {
            throw new \RuntimeException("Cannot write NBT file, directory does not exist: {$directory}");
        }

        $bytes = self::toBytes($tag, $compression, $format);
        if (@file_put_contents($path, $bytes) === false) {
            throw new \RuntimeException("Cannot write NBT file: {$path}");
        }
    }

    /**
     * Decode a CompoundTag from raw (possibly compressed) bytes.
     *
     * @param int $format one of {@see NbtFormat}
     */
    public static function fromBytes(string $data, int $format = NbtFormat::JAVA_EDITION): CompoundTag
    {
        $tag = Tag::load(self::detectReader($data, $format));

        if (!$tag instanceof CompoundTag) {
            throw CodecException::at(Path::root(), 'expected a compound tag at the root');
        }

        return $tag;
    }

    /**
     * Serialize a CompoundTag into raw bytes.
     *
     * @param int $compression one of {@see NbtIO} compression constants
     * @param int $format one of {@see NbtFormat}
     */
    public static function toBytes(CompoundTag $tag, int $compression = self::NONE, int $format = NbtFormat::JAVA_EDITION): string
    {
        $writer = new StringWriter();
        $writer->setFormat($format);
        $tag->write($writer);

        $bytes = $writer->getStringData();

        return match ($compression) {
            self::GZIP => gzencode($bytes) ?: $bytes,
            self::ZLIB => zlib_encode($bytes, ZLIB_ENCODING_DEFLATE) ?: $bytes,
            default => $bytes,
        };
    }

    private static function detectReader(string $data, int $format): Reader
    {
        // gzip magic bytes
        if (str_starts_with($data, "\x1f\x8b")) {
            return new GZipCompressedStringReader($data, $format);
        }

        // zlib header / deflate detection
        if (@zlib_decode($data) !== false) {
            return new ZLibCompressedStringReader($data, $format);
        }

        return new StringReader($data, $format);
    }
}