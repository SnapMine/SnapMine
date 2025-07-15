<?php

namespace Nirbose\PhpMcServ\Utils;

class MinecraftAES
{
    private string $key;

    // Le constructeur ne prend plus l'IV, car il sera géré par la session.
    public function __construct(string $key)
    {
        $this->key = str_pad(substr($key, 0, 16), 16, "\0"); // S'assure que la clé fait 16 octets
    }

    /**
     * Chiffre les données et retourne le ciphertext et le nouvel IV.
     * @param string $data Les données à chiffrer.
     * @param string $initialIv L'IV initial pour cette opération (doit être de 16 octets).
     * @return array [string $encryptedData, string $newIv]
     */
    public function encrypt(string $data, string $initialIv): array
    {
        $encrypted = '';
        // S'assure que l'IV initial est de 16 octets et l'utilise comme registre de départ.
        $register = str_pad(substr($initialIv, 0, 16), 16, "\0");

        for ($i = 0; $i < strlen($data); $i++) {
            $keystream = openssl_encrypt($register, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
            $encryptedByte = ord($data[$i]) ^ ord($keystream[0]);
            $encrypted .= chr($encryptedByte);
            // Le registre est mis à jour avec l'octet CHIFFRÉ actuel.
            $register = substr($register, 1) . chr($encryptedByte);
        }

        // Le nouvel IV pour la prochaine opération est les 16 derniers octets des données chiffrées actuelles.
        $newIv = substr($encrypted, -16);
        // Assure que le nouvel IV a toujours 16 octets, en le complétant si nécessaire.
        if (strlen($newIv) < 16) {
            $newIv = str_pad($newIv, 16, "\0", STR_PAD_LEFT);
        }

        return [$encrypted, $newIv];
    }

    /**
     * Déchiffre les données et retourne le plaintext et le nouvel IV.
     * @param string $data Les données chiffrées à déchiffrer.
     * @param string $initialIv L'IV initial pour cette opération (doit être de 16 octets).
     * @return array [string $decryptedData, string $newIv]
     */
    public function decrypt(string $data, string $initialIv): array
    {
        $decrypted = '';
        // S'assure que l'IV initial est de 16 octets et l'utilise comme registre de départ.
        $register = str_pad(substr($initialIv, 0, 16), 16, "\0");

        for ($i = 0; $i < strlen($data); $i++) {
            $keystream = openssl_encrypt($register, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
            $encryptedByte = ord($data[$i]); // L'octet chiffré actuel de l'entrée
            $decryptedByte = $encryptedByte ^ ord($keystream[0]);
            $decrypted .= chr($decryptedByte);
            // Le registre est mis à jour avec l'octet CHIFFRÉ actuel (celui lu depuis $data).
            $register = substr($register, 1) . chr($encryptedByte);
        }

        echo "Decrypted packet : " . bin2hex($decrypted) . PHP_EOL;

        // Le nouvel IV pour la prochaine opération est les 16 derniers octets des données chiffrées ACTUELLES ($data).
        $newIv = substr($data, -16);
        // Assure que le nouvel IV a toujours 16 octets, en le complétant si nécessaire.
        if (strlen($newIv) < 16) {
            $newIv = str_pad($newIv, 16, "\0", STR_PAD_LEFT);
        }

        return [$decrypted, $newIv];
    }
}