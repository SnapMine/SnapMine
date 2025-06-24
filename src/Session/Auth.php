<?php

namespace Nirbose\PhpMcServ\Session;

use Nirbose\PhpMcServ\Server;

class Auth {
    const BASE_URL = 'https://sessionserver.mojang.com/session/minecraft/hasJoined';

    public static function getInfo(string $username, string $sharedSecret): array {
        // Vérification des paramètres d'entrée
        if (empty($username) || empty($sharedSecret)) {
            throw new \InvalidArgumentException("Username et sharedSecret ne peuvent pas être vides");
        }

        // Construction du hash serverId selon le protocole Minecraft
        $data = $sharedSecret . Server::getPublicKey();
        
        // Calcul du SHA-1
        $hash = sha1($data, true);
        
        // Conversion en nombre signé (Two's complement pour les valeurs négatives)
        $serverId = self::minecraftSha1Hash($hash);

        // Debug - à retirer en production
        echo "Debug - Username: $username\n";
        echo "Debug - ServerId: $serverId\n";
        echo "Debug - SharedSecret length: " . strlen($sharedSecret) . "\n";

        $url = self::BASE_URL . "?" . http_build_query([
            'username' => $username,
            'serverId' => $serverId
        ]);

        echo "Debug - URL: $url\n";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_USERAGENT => 'PhpMcServ/1.0',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("Erreur cURL: $error");
        }

        switch ($httpCode) {
            case 200:
                echo "✅ Utilisateur authentifié avec succès !\n";
                $data = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception("Réponse JSON invalide: " . json_last_error_msg());
                }
                return $data;
                
            case 204:
                echo "❌ Aucun utilisateur trouvé (HTTP 204)\n";
                echo "Causes possibles:\n";
                echo "- L'utilisateur n'est pas connecté au launcher Minecraft\n";
                echo "- Le serverId calculé ne correspond pas\n";
                echo "- Le timing entre la connexion client et la vérification serveur\n";
                return [];
                
            case 403:
                echo "❌ Refusé (HTTP 403): L'utilisateur n'est pas connecté à Mojang\n";
                return [];
                
            default:
                echo "⚠️ Erreur inconnue (HTTP $httpCode): $response\n";
                return [];
        }
    }

    /**
     * Calcule le hash serverId selon les spécifications Minecraft
     * Implémente la logique de two's complement pour les hash négatifs
     */
    private static function minecraftSha1Hash(string $hash): string {
        // Conversion en nombre GMP
        $gmp = gmp_import($hash);
        
        // Vérification si le nombre est négatif (bit de signe à 1)
        // 0x8000000000000000000000000000000000000000 = 2^159
        if (gmp_cmp($gmp, gmp_init("0x8000000000000000000000000000000000000000")) >= 0) {
            // Calcul du complément à deux pour les nombres négatifs
            // NOT(hash) + 1, puis multiplier par -1
            $notHash = gmp_xor($gmp, gmp_init("0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF"));
            $gmp = gmp_mul(gmp_add($notHash, 1), -1);
        }
        
        return gmp_strval($gmp, 16);
    }

    /**
     * Méthode alternative pour débugger le processus d'authentification
     */
    public static function debugAuth(string $username, string $sharedSecret): void {
        echo "=== DEBUG AUTHENTIFICATION ===\n";
        echo "Username: $username\n";
        echo "SharedSecret (hex): " . bin2hex($sharedSecret) . "\n";
        
        $publicKey = Server::getPublicKey();
        echo "Public Key length: " . strlen($publicKey) . "\n";
        echo "Public Key (hex): " . bin2hex($publicKey) . "\n";
        
        $data = $sharedSecret . $publicKey;
        echo "Data length: " . strlen($data) . "\n";
        
        $hash = sha1($data, true);
        echo "SHA1 hash (hex): " . bin2hex($hash) . "\n";
        
        $serverId = self::minecraftSha1Hash($hash);
        echo "ServerId: $serverId\n";
        echo "=============================\n";
    }
}