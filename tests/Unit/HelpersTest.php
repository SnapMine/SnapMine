<?php

test('Test get_block_state_offset', function () {
    $data = json_decode(file_get_contents(__DIR__ . "/../../resources/blocks_states.json"), true);
    $button = $data['minecraft:acacia_button'];

    $offset = get_block_state_offset([2, 3, 0], $button['coef']);

    expect(9492 + $offset)->toBe(9514);
});