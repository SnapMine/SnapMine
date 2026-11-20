<?php

declare(strict_types=1);

namespace SnapMine\Registry;

use SnapMine\Codec\Codec;
use SnapMine\Codec\CodecProvider;
use SnapMine\Codec\Field;
use SnapMine\Codec\RecordCodec;

/**
 * @extends RegistryData<ChatType>
 *
 * @method static ChatType CHAT()
 * @method static ChatType EMOTE_COMMAND()
 * @method static ChatType MSG_COMMAND_INCOMING()
 * @method static ChatType MSG_COMMAND_OUTGOING()
 * @method static ChatType SAY_COMMAND()
 * @method static ChatType TEAM_MSG_COMMAND_INCOMING()
 * @method static ChatType TEAM_MSG_COMMAND_OUTGOING()
 */
final class ChatType extends RegistryData implements CodecProvider
{
    public function __construct(
        private readonly ChatData $chat,
        private readonly ChatData $narration,
    ) {
    }

    public static function codec(): Codec
    {
        static $codec;

        return $codec ??= RecordCodec::of(
            self::class,
            Field::required('chat', ChatData::codec(), fn (self $c) => $c->chat),
            Field::required('narration', ChatData::codec(), fn (self $c) => $c->narration),
        );
    }

    public function getChat(): ChatData
    {
        return $this->chat;
    }

    public function getNarration(): ChatData
    {
        return $this->narration;
    }
}
