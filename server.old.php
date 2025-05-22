<?php

set_time_limit(0);

$host = "0.0.0.0";
$port = 25565;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($sock, $host, $port);
socket_listen($sock);

echo "🚀 Serveur Minecraft PHP démarré sur $host:$port\n";

while (true) {
    $client = socket_accept($sock);
    if (!$client) continue;

    echo "\n➤ Connexion reçue\n";

    $buffer = socket_read($client, 2048);
    if (!$buffer || strlen($buffer) < 1) {
        echo "❌ Aucun paquet reçu\n";
        socket_close($client);
        continue;
    }

    $offset = 0;
    try {
        $packetLength = readVarInt($buffer, $offset);
        $packetId = readVarInt($buffer, $offset);
    } catch (Exception $e) {
        echo "❌ Erreur lecture VarInt : " . $e->getMessage() . "\n";
        socket_close($client);
        continue;
    }

    if ($packetId !== 0x00) {
        echo "⚠️ Paquet inattendu ($packetId), ignoré\n";
        socket_close($client);
        continue;
    }

    try {
        $protocolVersion = readVarInt($buffer, $offset);
        $addrLen = readVarInt($buffer, $offset);
        $serverAddress = substr($buffer, $offset, $addrLen);
        $offset += $addrLen;
        $serverPort = unpack("n", substr($buffer, $offset, 2))[1];
        $offset += 2;
        $nextState = ord($buffer[$offset]);
        $offset++;
    } catch (Exception $e) {
        echo "❌ Erreur parsing Handshake : " . $e->getMessage() . "\n";
        socket_close($client);
        continue;
    }

    echo "📥 Handshake reçu : État = $nextState\n";

    if ($nextState === 1) {
        handleStatus($client);
    } elseif ($nextState === 2) {
        handleLogin($client);
    } else {
        echo "❌ État inconnu : $nextState\n";
        socket_close($client);
    }
}

function handleStatus($client) {
    $request = socket_read($client, 512);
    if (!$request) {
        echo "❌ Aucune requête status reçue\n";
        socket_close($client);
        return;
    }

    $offset = 0;
    try {
        readVarInt($request, $offset); // longueur
        $packetId = readVarInt($request, $offset);
    } catch (Exception $e) {
        echo "❌ Erreur status VarInt : " . $e->getMessage() . "\n";
        socket_close($client);
        return;
    }

    if ($packetId !== 0x00) {
        echo "❌ Mauvais ID de status (reçu $packetId)\n";
        socket_close($client);
        return;
    }

    $json = json_encode([
        "version" => ["name" => "1.20.4", "protocol" => 765],
        "players" => [
            "max" => 10,
            "online" => 1,
            "sample" => [["name" => "PHPBot", "id" => "00000000-0000-0000-0000-000000000000"]]
        ],
        "description" => ["text" => "§aServeur PHP prêt !"],
    ], JSON_UNESCAPED_UNICODE);

    $response = encodeVarInt(0x00) . encodeString($json);
    $packet = encodeVarInt(strlen($response)) . $response;
    socket_write($client, $packet);
    echo "✅ Status envoyé\n";

    // Gestion du ping
    $ping = socket_read($client, 512);
    if (!$ping) {
        echo "❌ Pas de ping reçu\n";
        socket_close($client);
        return;
    }

    $off = 0;
    try {
        readVarInt($ping, $off);
        $pingId = readVarInt($ping, $off);
        $payload = substr($ping, $off);
    } catch (Exception $e) {
        echo "❌ Erreur ping : " . $e->getMessage() . "\n";
        socket_close($client);
        return;
    }

    if ($pingId === 0x01) {
        $pong = encodeVarInt(0x01) . $payload;
        socket_write($client, encodeVarInt(strlen($pong)) . $pong);
        echo "🔁 Pong envoyé\n";
    }

    socket_close($client);
}

function handleLogin($client) {
    echo "🔐 Mode login : attente du pseudo\n";

    $loginStart = socket_read($client, 512);
    if (!$loginStart || strlen($loginStart) === 0) {
        echo "❌ Paquet Login Start manquant\n";
        socket_close($client);
        return;
    }

    echo "📦 Login Start brut : " . bin2hex($loginStart) . "\n";

    $offset = 0;

    try {
        $packetLen = readVarInt($loginStart, $offset);
        $packetId = readVarInt($loginStart, $offset);
        if ($packetId !== 0x00) {
            echo "❌ Mauvais ID Login Start (reçu $packetId)\n";
            socket_close($client);
            return;
        }

        $name = readString($loginStart, $offset);
    } catch (Exception $e) {
        echo "❌ Erreur parsing login : " . $e->getMessage() . "\n";
        socket_close($client);
        return;
    }

    echo "👤 Pseudo reçu : $name\n";

    // UUID offline
    $uuid = generateOfflineUUID($name);

    $response = encodeVarInt(0x02) . encodeString($uuid) . encodeString($name);
    $packet = encodeVarInt(strlen($response)) . $response;
    socket_write($client, $packet);
    echo "✅ Login Success envoyé\n";

    // Le client passe en état "Play"
    socket_close($client);
}

// ---------- Fonctions utilitaires ----------
function readVarInt($buffer, &$offset) {
    $value = 0;
    $pos = 0;
    while (true) {
        if (!isset($buffer[$offset])) {
            throw new Exception("Fin de buffer pour VarInt (offset $offset)");
        }
        $byte = ord($buffer[$offset++]);
        $value |= ($byte & 0x7F) << $pos;
        if (($byte & 0x80) === 0) break;
        $pos += 7;
        if ($pos > 35) throw new Exception("VarInt trop long");
    }
    return $value;
}

function encodeVarInt($value) {
    $out = '';
    do {
        $temp = $value & 0x7F;
        $value >>= 7;
        if ($value !== 0) $temp |= 0x80;
        $out .= chr($temp);
    } while ($value !== 0);
    return $out;
}

function readString($buffer, &$offset) {
    $len = readVarInt($buffer, $offset);
    $str = substr($buffer, $offset, $len);
    if (strlen($str) < $len) {
        throw new Exception("Chaîne tronquée (attendu $len octets, reçu " . strlen($str) . ")");
    }
    $offset += $len;
    return $str;
}

function encodeString($str) {
    return encodeVarInt(strlen($str)) . $str;
}

function generateOfflineUUID($name) {
    $hash = md5("OfflinePlayer:" . $name);
    return substr($hash, 0, 8) . "-" .
           substr($hash, 8, 4) . "-3" .
           substr($hash, 13, 3) . "-a" .
           substr($hash, 17, 3) . "-" .
           substr($hash, 20, 12);
}
