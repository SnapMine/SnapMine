<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Nirbose\PhpMcServ\Block\BlockStateLoader;
use Nirbose\PhpMcServ\Material;

interface BlockData
{
    public function getMaterial(): Material;
    public function computedId(BlockStateLoader $loader): int;


}