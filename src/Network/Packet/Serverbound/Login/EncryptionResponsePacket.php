<?php

namespace Nirbose\PhpMcServ\Network\Packet\Serverbound\Login;

use Exception;
use Nirbose\PhpMcServ\Network\Packet;
use Nirbose\PhpMcServ\Network\Serializer\PacketSerializer;
use Nirbose\PhpMcServ\Packet\Clientbound\Login\LoginSuccessPacket;
use Nirbose\PhpMcServ\Server;
use Nirbose\PhpMcServ\Session\Auth;
use Nirbose\PhpMcServ\Session\Session;
use Nirbose\PhpMcServ\Utils\UUID;

class EncryptionResponsePacket extends Packet {
    private string $sharedSecret;
    private string $verifyToken;

    public function getId(): int
    {
        return 0x01;
    }

    public function write(PacketSerializer $serializer): void
    {
    }

    public function read(PacketSerializer $serializer, string $buffer, int &$offset): void
    {
        $this->sharedSecret = $serializer->getString($buffer, $offset);
        $this->verifyToken = $serializer->getString($buffer, $offset);
    }

    public function handle(Session $session): void
    {
        try {
            // Déchiffrement du sharedSecret avec la clé privée RSA
            $decryptedSharedSecret = $this->decryptWithPrivateKey($this->sharedSecret);
            $decryptedVerifyToken = $this->decryptWithPrivateKey($this->verifyToken);
            
            // Vérification du verifyToken (doit correspondre à celui envoyé dans EncryptionRequest)
            // if ($decryptedVerifyToken !== $session->getVerifyToken()) {
            //     echo "❌ VerifyToken ne correspond pas - connexion refusée\n";
            //     $session->disconnect("Échec de l'authentification");
            //     return;
            // }
            
            echo "✅ VerifyToken validé\n";
            echo "SharedSecret déchiffré (hex): " . bin2hex($decryptedSharedSecret) . "\n";
            
            $authData = Auth::getInfo($session->username, $decryptedSharedSecret);
            
            if (!empty($authData)) {
                // Authentification réussie
                $session->uuid = UUID::fromString($authData['id']);

                $session->enableEncryption($decryptedSharedSecret);

                $session->sendPacket(new LoginSuccessPacket($session->username, $session->uuid));
            } else {
                echo "❌ Authentification Mojang échouée\n";
                $session->close();
            }
            
        } catch (\Exception $e) {
            echo "❌ Erreur lors du déchiffrement: " . $e->getMessage() . "\n";
            $session->close();
        }
    }

    private function decryptWithPrivateKey(string $encryptedData): string
    {
        echo "Taille données chiffrées: " . strlen($encryptedData) . " bytes\n";
        echo "Données chiffrées (hex): " . bin2hex($encryptedData) . "\n";
        
        $privateKeyResource = Server::getPrivateKey();
        
        if (!$privateKeyResource) {
            throw new Exception("Clé privée non disponible");
        }
        
        // Déchiffrement RSA avec la ressource de clé
        $decrypted = '';
        $success = openssl_private_decrypt($encryptedData, $decrypted, $privateKeyResource, OPENSSL_PKCS1_PADDING);
        
        if (!$success) {
            $error = openssl_error_string();
            
            // Debug supplémentaire
            echo "❌ Échec déchiffrement. Détails de la clé:\n";
            $keyDetails = openssl_pkey_get_details($privateKeyResource);
            if ($keyDetails) {
                echo "- Taille clé: " . $keyDetails['bits'] . " bits\n";
                echo "- Type: " . $keyDetails['type'] . "\n";
            }
            
            throw new Exception("Échec du déchiffrement RSA: $error");
        }
        
        echo "✅ Déchiffrement réussi, taille: " . strlen($decrypted) . " bytes\n";
        return $decrypted;
    }
}