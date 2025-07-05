<?php

namespace Nirbose\PhpMcServ\Utils;

class MinecraftAES
{
    private string $key;
    private string $iv;

    public function __construct(string $key, string $iv)
    {
        $this->key = str_pad(substr($key, 0, 16), 16, "\0");
        $this->iv = str_pad(substr($iv, 0, 16), 16, "\0");
    }

    public function encrypt(string $data): string
    {
        $encrypted = '';
        $register = $this->iv;

        echo "Packet (before AES): " . bin2hex($data) . PHP_EOL;

        for ($i = 0; $i < strlen($data); $i++) {
            // Chiffrer le registre avec AES-ECB
            $keystream = openssl_encrypt($register, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);

            // XOR avec le premier byte du keystream
            $encryptedByte = ord($data[$i]) ^ ord($keystream[0]);
            $encrypted .= chr($encryptedByte);

            // Décaler le registre et ajouter le byte chiffré
            $register = substr($register, 1) . chr($encryptedByte);
        }

        echo "Packet (after AES): " . bin2hex($encrypted) . PHP_EOL;

        return $encrypted;
    }

    public function decrypt(string $data): string
    {
        $decrypted = '';
        $register = $this->iv;

        for ($i = 0; $i < strlen($data); $i++) {
            // Chiffrer le registre avec AES-ECB
            $keystream = openssl_encrypt($register, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);

            // XOR avec le premier byte du keystream
            $encryptedByte = ord($data[$i]);
            $decryptedByte = $encryptedByte ^ ord($keystream[0]);
            $decrypted .= chr($decryptedByte);

            // IMPORTANT: Décaler le registre avec le byte CHIFFRÉ (pas déchiffré)
            $register = substr($register, 1) . chr($encryptedByte);
        }

        echo "Decrypted packet : " . bin2hex($decrypted) . PHP_EOL;
        return $decrypted;
    }
}