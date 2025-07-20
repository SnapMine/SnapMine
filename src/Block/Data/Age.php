<?php

namespace Nirbose\PhpMcServ\Block\Data;

interface Age extends BlockData
{
    public function getMaximumAge(): int;

    public function setAge(int $age): void;

    public function getAge(): int;
}