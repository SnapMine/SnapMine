<?php

$data = json_decode(file_get_contents("./entity_type.json"), true);
$types = [];

foreach ($data as $key => $type) {
    $types[] = "\tcase " . strtoupper(str_replace("minecraft:", "", $key)) . " = " . $type['protocol_id'] . ";";
}

$str = implode("\n", $types);

file_put_contents("src/Entity/EntityType.php", "<?php

namespace Nirbose\PhpMcServ\Entity;

enum EntityType: int
{
$str
}
"
);