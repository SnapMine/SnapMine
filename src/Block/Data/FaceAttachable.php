<?php

namespace Nirbose\PhpMcServ\Block\Data;

use Nirbose\PhpMcServ\Block\AttachedFace;

interface FaceAttachable extends BlockData
{
    public function getAttachedFace(): AttachedFace;

    public function setAttachedFace(AttachedFace $face): void;
}