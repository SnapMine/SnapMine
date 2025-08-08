<?php

namespace Nirbose\PhpMcServ\BossBar;

use Nirbose\PhpMcServ\Component\TextComponent;
use Nirbose\PhpMcServ\Entity\Player;
use Nirbose\PhpMcServ\Network\Packet\Clientbound\Play\BossEventPacket;
use Nirbose\PhpMcServ\Utils\UUID;

class BossBar
{
    private readonly UUID $uuid;
    private float $health = 0.0;
    /** @var array<Player> $players */
    private array $players = [];

    public function __construct(
        private TextComponent $title,
        private BarColor $color = BarColor::PINK,
        private BarStyle $division = BarStyle::NOTCHES_0,
        private int $flags = 0x01,
    )
    {
        $this->uuid = UUID::generate();
    }

    /**
     * @return UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return TextComponent
     */
    public function getTitle(): TextComponent
    {
        return $this->title;
    }

    /**
     * @param TextComponent $title
     */
    public function setTitle(TextComponent $title): self
    {
        $this->title = $title;

        $this->update(BossBarAction::UPDATE_TITLE);

        return $this;
    }

    /**
     * @return BarColor
     */
    public function getColor(): BarColor
    {
        return $this->color;
    }

    /**
     * @param BarColor $color
     */
    public function setColor(BarColor $color): self
    {
        $this->color = $color;

        $this->update(BossBarAction::UPDATE_STYLE);

        return $this;
    }

    /**
     * @return BarStyle
     */
    public function getDivision(): BarStyle
    {
        return $this->division;
    }

    /**
     * @param BarStyle $division
     */
    public function setDivision(BarStyle $division): self
    {
        $this->division = $division;

        $this->update(BossBarAction::UPDATE_STYLE);

        return $this;
    }

    private function update(BossBarAction $action): void
    {
        foreach ($this->players as $player) {
            $player->sendPacket(new BossEventPacket($action, $this));
        }
    }

    /**
     * @return float
     */
    public function getHealth(): float
    {
        return $this->health;
    }

    /**
     * @param float $health
     */
    public function setHealth(float $health): self
    {
        $this->health = $health;

        $this->update(BossBarAction::UPDATE_HEALTH);

        return $this;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): self
    {
        $this->flags = $flags;

        $this->update(BossBarAction::UPDATE_FLAGS);

        return $this;
    }

    public function addPlayer(Player $player): self
    {
        $this->players[$player->getUuid()->toString()] = $player;

        $player->sendPacket(new BossEventPacket(BossBarAction::ADD, $this));

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        unset($this->players[$player->getUuid()->toString()]);

        $player->sendPacket(new BossEventPacket(BossBarAction::REMOVE, $this));

        return $this;
    }

    /**
     * @return array<Player>
     */
    public function getPlayers(): array
    {
        return $this->players;
    }
}