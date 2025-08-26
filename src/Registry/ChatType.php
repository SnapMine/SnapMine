<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Keyed;

/**
 * @method static ChatType CHAT()
 * @method static ChatType EMOTE_COMMAND()
 * @method static ChatType MSG_COMMAND_INCOMING()
 * @method static ChatType MSG_COMMAND_OUTGOING()
 * @method static ChatType SAY_COMMAND()
 * @method static ChatType TEAM_MSG_COMMAND_INCOMING()
 * @method static ChatType TEAM_MSG_COMMAND_OUTGOING()
 */
class ChatType implements EncodableToNbt, Keyed
{
    /** @var array<string, self> */
    protected static array $entries = [];

    public function __construct(
        protected readonly string $key,
        protected readonly array $data,
        protected readonly int $id,
    )
    {
    }

    public static function register(string $name, string $key, array $data): self
    {
        $instance = new self($key, $data, count(self::$entries));
        self::$entries[strtoupper($name)] = $instance;

        return $instance;
    }

    public static function __callStatic(string $name, array $args): self {
        $name = strtoupper($name);
        if (!isset(self::$entries[$name])) {
            throw new \RuntimeException("ChatType '$name' not found");
        }

        return self::$entries[$name];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public static function getEntries(): array
    {
        return self::$entries;
    }

    public function toNbt(): CompoundTag
    {
        $base = new CompoundTag();

        $narration = new CompoundTag();

        $narration->set('translation_key', (new StringTag())->setValue($this->data['narration']['translation_key']));

        $narrationParameters = new ListTag();

        foreach ($this->data['narration']['parameters'] as $parameter) {
            $narrationParameters[] = (new StringTag())->setValue($parameter);
        }

        $narration->set('parameters', $narrationParameters);

        $base->set('narration', $narration);

        $chat = (new CompoundTag())
            ->set('translation_key', (new StringTag())->setValue($this->data['chat']['translation_key']));

        $chatParameters = new ListTag();

        foreach ($this->data['chat']['parameters'] as $parameter) {
            $chatParameters[] = (new StringTag())->setValue($parameter);
        }

        $chat->set('parameters', $narrationParameters);

        if (isset($this->data['chat']['style'])) {
            $chat->set('style', (new CompoundTag())
                ->set('color', (new StringTag())->setValue($this->data['chat']['style']['color']))
                ->set('italic', (new ByteTag())->setValue($this->data['chat']['style']['italic']))
            );
        }

        $base->set('chat', $chat);

        return $base;
    }
}