<?php

namespace SnapMine\Exception;

use Exception;

class UnimplementException extends Exception
{
    public function __construct()
    {
        parent::__construct('This method is not implemented yet.');
    }
}