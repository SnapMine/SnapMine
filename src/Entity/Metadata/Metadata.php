<?php

namespace Nirbose\PhpMcServ\Entity\Metadata;

use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

trait Metadata
{
    /**
     * @var array<int, MetadataEntry>
     */
    private array $entries = [];

    public function setMetadata(int $index, MetadataType $type, mixed $value): void
    {
        $this->entries[$index] = new MetadataEntry($type, $value);
    }

    public function getMetadata(int $index): ?MetadataEntry
    {
        return $this->entries[$index] ?? null;
    }

    public function hasMetadata(int $index): bool
    {
        return isset($this->entries[$index]);
    }

    public function removeMetadata(int $index): void
    {
        unset($this->entries[$index]);
    }

    public function getAllMetadata(): array
    {
        return $this->entries;
    }

    public function serialize(): string
    {
        $data = new PacketSerializer("");

        foreach ($this->entries as $index => $entry) {
            $data->putUnsignedByte($index);

            $data->put($entry->serialize());
        }

        $data->putUnsignedByte(0xFF);

        return $data->get();
    }
}