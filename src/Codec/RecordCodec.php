<?php

declare(strict_types=1);

namespace SnapMine\Codec;

/**
 * Combines several {@see Field}s into a codec for a whole record.
 *
 * Decoding reads the fields of the map node in declaration order and passes
 * them positionally to the record constructor. Encoding calls each field
 * getter, encodes its value and assembles the resulting map node. Optional
 * fields holding `null` are omitted from the encoded output.
 *
 * @template T of object
 * @implements Codec<T>
 */
final class RecordCodec implements Codec
{
    /** @var Field[] */
    private readonly array $fields;

    /**
     * @param class-string<T> $class
     * @param Field[] $fields
     */
    private function __construct(
        private readonly string $class,
        array $fields
    ) {
        $this->fields = array_values($fields);
    }

    /**
     * @template U of object
     * @param class-string<U> $class
     * @return RecordCodec<U>
     */
    public static function of(string $class, Field ...$fields): self
    {
        return new self($class, $fields);
    }

    /**
     * @return T
     */
    public function decode(Ops $ops, mixed $input, Path $path): mixed
    {
        $map = $ops->getMap($input, $path);

        $args = [];
        foreach ($this->fields as $field) {
            $key = $field->key();
            $present = array_key_exists($key, $map);

            switch ($field->kind()) {
                case Field::REQUIRED:
                    if (!$present) {
                        throw CodecException::at($path->child($key), 'missing');
                    }
                    $args[] = $field->codec()->decode($ops, $map[$key], $path->child($key));
                    break;

                case Field::OPTIONAL:
                    $args[] = $present
                        ? $field->codec()->decode($ops, $map[$key], $path->child($key))
                        : null;
                    break;

                case Field::WITH_DEFAULT:
                    $args[] = $present
                        ? $field->codec()->decode($ops, $map[$key], $path->child($key))
                        : $field->default();
                    break;
            }
        }

        $class = $this->class;

        /** @var T $record */
        $record = new $class(...$args);

        return $record;
    }

    /**
     * @param T $value
     */
    public function encode(Ops $ops, mixed $value): mixed
    {
        $map = [];
        foreach ($this->fields as $field) {
            $raw = $field->get($value);

            if ($field->kind() === Field::OPTIONAL && $raw === null) {
                continue;
            }

            if ($field->kind() === Field::WITH_DEFAULT && $raw === null) {
                $raw = $field->default();
            }

            $map[$field->key()] = $field->codec()->encode($ops, $raw);
        }

        return $ops->createMap($map);
    }
}