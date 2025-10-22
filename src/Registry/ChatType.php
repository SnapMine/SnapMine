<?php

namespace SnapMine\Registry;

use Aternos\Nbt\Tag\ByteTag;
use Aternos\Nbt\Tag\CompoundTag;
use Aternos\Nbt\Tag\ListTag;
use Aternos\Nbt\Tag\StringTag;
use SnapMine\Keyed;
use SnapMine\Nbt\NbtCompound;
use SnapMine\NbtSerializable;

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
class ChatType extends RegistryData implements NbtSerializable
{
    #[NbtCompound('chat')]
    private ChatData $chat;

    #[NbtCompound('narration')]
    private ChatData $narration;
}