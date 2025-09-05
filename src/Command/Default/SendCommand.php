<?php


use SnapMine\Command\ArgumentTypes\ArgumentEntity;
use SnapMine\Command\ArgumentTypes\BrigadierString;
use SnapMine\Command\Command;
use SnapMine\Entity\Player;

Command::new('send')
    ->arguments(
        ['entity' => new ArgumentEntity(), 'message' => new BrigadierString(BrigadierString::GREEDY_PHRASE)],
        function (Player $sender, ArgumentEntity $target, BrigadierString $message) {
            $target->getValue()->sendMessage($sender->getName() . " => you : " . $message->getValue());
            $sender->sendMessage("you => " . $sender->getName() . " : " . $message->getValue());
        })->build();