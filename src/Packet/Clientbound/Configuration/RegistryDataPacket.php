<?php

namespace Nirbose\PhpMcServ\Packet\Clientbound\Configuration;

use Aternos\Nbt\IO\Writer\StringWriter;
use Aternos\Nbt\NbtFormat;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use Aternos\Nbt\Tag\Tag;
use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Registry;
use Nirbose\PhpMcServ\Session\Session;
use stdClass;

class RegistryDataPacket extends Packet
{
    private string $registryId;
    private stdClass $entries;

    public function __construct(string $registryId, stdClass $entries)
    {
        $this->registryId = $registryId;
        $this->entries = $entries;
    }

    public function getId(): int
    {
        return 0x07;
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        throw new \Exception("RegistryDataPacket ne peut pas être reçu");
    }

    public function write(PacketSerializer $serializer): void
    {
        $serializer->putString($this->registryId);

        $serializer->putVarInt(count((array) $this->entries));

        $nbtTags = Registry::getRegistry($this->registryId);

        foreach ($this->entries as $entryId => $entryData) {
            $serializer->putString($entryId);

            $serializer->putBool(true);

            $component = $this->convertToNbtTag($nbtTags, $entryData);

            $writer = (new StringWriter())
                ->setFormat(NbtFormat::JAVA_EDITION);
            $component->writeData($writer, false);
            $nbtString = $writer->getStringData();

            $serializer->put($nbtString);

            file_put_contents("nbt/" . str_replace(['/', ':'], "_", $this->registryId) . ".txt", "\n" . $entryId . "\n" . bin2hex($serializer->get()). "\n", FILE_APPEND);
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
                // Sous-structure (ex: description, effects, mood_sound, etc.)
                $compound[$tagName] = $this->convertToNbtTag($tagType, $value);
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


    public function handle(Session $session): void
    {
        // Ce paquet est envoyé par le serveur, pas géré côté client
    }
}