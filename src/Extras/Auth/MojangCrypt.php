<?php

namespace Nirbose\PhpMcServ\Extras\Auth;

use RuntimeException;

class MojangCrypt
{
    public static function generateKeyPair(): array
    {
        $keys = [
            'private' => null,
            'public' => null,
        ];
        $config = [
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
            "private_key_bits" => 1024,
            "digest_alg" => "sha1"
        ];

        $keyResource = openssl_pkey_new($config);
        if (!$keyResource) {
            throw new RuntimeException("Impossible de générer la paire de clés RSA: " . openssl_error_string());
        }

        // Export private key
        if (!openssl_pkey_export($keyResource, $keys['private'])) {
            throw new RuntimeException("Impossible d'exporter la clé privée: " . openssl_error_string());
        }

        // Get public key
        $publicKeyDetails = openssl_pkey_get_details($keyResource);
        if (!$publicKeyDetails) {
            throw new RuntimeException("Impossible de récupérer les détails de la clé publique");
        }

        // public key PEM to DER
        $keys['public'] = self::pemToDer($publicKeyDetails['key']);

        return $keys;
    }

    private static function pemToDer(string $pem): string
    {
        $pem = preg_replace('/-----BEGIN PUBLIC KEY-----/', '', $pem);
        $pem = preg_replace('/-----END PUBLIC KEY-----/', '', $pem);
        $pem = str_replace(["\r", "\n"], '', $pem);
        return base64_decode($pem);
    }
}