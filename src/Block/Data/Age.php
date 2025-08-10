<?php

namespace Nirbose\PhpMcServ\Block\Data;

trait Age
{
    protected int $age = 0;

    abstract public function getMaximumAge(): int;

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}