<?php

namespace Nirbose\PhpMcServ\Network\Packet\Clientbound\Configuration;

use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\ClientboundPacket;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;

class RegistryDataPacket extends ClientboundPacket
{
    /**
     * @param string $registryId
     * @param array<string, object> $entries
     */
    public function __construct(
        private readonly string $registryId,
        private readonly array $entries
    )
    {
    }

    public function getId(): int
    {
        return 0x07;
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->registryId)
            ->putVarInt(count($this->entries));

        foreach ($this->entries as $entry) {
            $serializer->putNBT($entry->toNbt());
        }
    }

    private function convertToNbtTag(array $nbtTags, $entryData): CompoundTag
    {
        $compound = new CompoundTag();

        foreach ($nbtTags as $tagName => $tagType) {
            if (!property_exists($entryData, $tagName)) {
                continue;
            }

            $value = $entryData->{$tagName};

            if (is_array($tagType)) {
                // Type liste ou objet composite
                if (isset($tagType[0]) && is_string($tagType[0]) && is_subclass_of($tagType[0], Tag::class)) {
                    // C'est une liste
                    $listTag = new ListTag();

                    $elementType = $tagType[1];
                    if (!is_string($value)) {
                        foreach ($value as $item) {
                            if (is_array($elementType)) {
                                $listTag[] = $this->convertToNbtTag($elementType, $item);
                            } else {
                                $element = new $elementType();
                                $element->setValue($item);
                                $listTag[] = $element;
                            }
                        }
                    }

                    $compound[$tagName] = $listTag;
                } else {
                    // Sous-tag composé (objet JSON imbriqué)
                    $compound[$tagName] = $this->convertToNbtTag($tagType, $value);
                }

            } else {
                if ($tagType === null) {
                    continue;
                }

                /** @var Tag $tagInstance */
                $tagInstance = new $tagType();

                if ($tagInstance instanceof ListTag) {
                    if (is_string($value)) {
                        $value = [$value];
                    }
                    foreach ($value as $item) {
                        $stringTag = new StringTag();
                        $stringTag->setValue($item);
                        $tagInstance[] = $stringTag;
                    }
                    $compound[$tagName] = $tagInstance;
                } else {
                    if ($value === null) {
                        throw new \InvalidArgumentException("Valeur nulle pour le champ '$tagName' qui est requis.");
                    }

                    $tagInstance->setValue($value);
                    $compound[$tagName] = $tagInstance;
                }
            }
        }

        return $compound;
    }
}