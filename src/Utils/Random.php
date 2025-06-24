<?php

namespace Nirbose\PhpMcServ\Utils;

class Random {
    public static function str(int $length = 16): string {
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= chr(mt_rand(33, 126));
        }
        
        return $randomString;
    }
}