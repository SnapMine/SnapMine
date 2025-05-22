<?php

if (!function_exists('packet_dump')) {
    function packet_dump($data): void
    {
        $output = '';
        foreach (str_split($data, 16) as $chunk) {
            $hex = bin2hex($chunk);
            $ascii = preg_replace('/[^\x20-\x7E]/', '.', $chunk);
            $output .= sprintf("%s | %s\n", strtoupper($hex), $ascii);
        }
        echo $output;
    }
}