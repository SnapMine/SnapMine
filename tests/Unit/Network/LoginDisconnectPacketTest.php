<?php

declare(strict_types=1);

use SnapMine\Component\TextComponent;
use SnapMine\Network\Packet\Clientbound\Login\DisconnectPacket;
use SnapMine\Network\Serializer\PacketSerializer;

/**
 * Builds the full packet payload exactly like Session::sendPacket() does:
 * VarInt packet id, then the packet body.
 */
function encodeLoginDisconnect(TextComponent $reason): string
{
    $serializer = new PacketSerializer('', 0);
    $packet = new DisconnectPacket($reason);

    $serializer->putVarInt($packet->getId());
    $packet->write($serializer);

    return $serializer->get();
}

it('uses the login disconnect packet id 0x00', function () {
    expect((new DisconnectPacket(TextComponent::text('x')))->getId())->toBe(0x00);
});

it('writes the reason as a JSON Text Component string (not NBT)', function () {
    // Per protocol spec, login_disconnect's reason is a "JSON Text Component":
    // a VarInt-length-prefixed UTF-8 string containing JSON. Only the
    // configuration/play disconnect packets use NBT text components.
    $payload = encodeLoginDisconnect(TextComponent::text('No Worlds found.'));

    $json = '{"text":"No Worlds found."}';

    $expected =
        "\x00"                  // packet id 0x00
        . chr(strlen($json))    // VarInt string length (23)
        . $json;                // UTF-8 JSON

    expect($payload)->toBe($expected);
});

it('is fully consumed when the client reads the reason as a String', function () {
    // Simulates the vanilla client: VarInt packet id, then VarInt-length
    // string for the reason. No byte may be left over, otherwise the client
    // throws "was larger than I expected, found N bytes extra".
    $payload = encodeLoginDisconnect(TextComponent::text('No Worlds found.'));

    $client = new PacketSerializer($payload);
    $packetId = $client->getVarInt();
    $length = $client->getVarInt();
    $reason = json_decode($client->getNBytes($length), true);

    expect($packetId)->toBe(0x00)
        ->and($client->getOffset())->toBe(strlen($payload))
        ->and($reason)->toBe(['text' => 'No Worlds found.']);
});

it('encodes styled components into the JSON string', function () {
    $reason = TextComponent::text('Bye')->color(0xFF0000)->bold(true);

    $payload = encodeLoginDisconnect($reason);

    $client = new PacketSerializer($payload);
    expect($client->getVarInt())->toBe(0x00);

    $json = json_decode($client->getNBytes($client->getVarInt()), true);

    expect($json['text'])->toBe('Bye')
        ->and($json['color'])->toBe('#ff0000')
        ->and($json['bold'])->toBeTrue();
});

it('regression: an NBT-encoded reason leaves 16 unread bytes for the client', function () {
    // The previous implementation wrote the reason as a network NBT
    // compound. A client reading the reason as a String would consume
    // VarInt(0x0A) = 10 bytes and leave exactly strlen("No Worlds found.")
    // = 16 extra bytes — the DecoderException reported by players.
    $nbtPayload =
        "\x00"                          // packet id 0x00
        . "\x0a"                        // TAG_Compound (unnamed root)
        . "\x08\x00\x04text"            // TAG_String named "text"
        . "\x00\x10"                    // string length: 16
        . 'No Worlds found.'            // 16 bytes of UTF-8
        . "\x00";                       // TAG_End

    $client = new PacketSerializer($nbtPayload);
    $client->getVarInt(); // packet id
    $declared = $client->getVarInt(); // old client reads 0x0A = 10 as the string length
    $client->getNBytes($declared);

    expect(strlen($nbtPayload) - $client->getOffset())->toBe(16);
});
