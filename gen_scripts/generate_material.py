import json

data_items = {}

def create_php_enum():

    cases = "" + "\n".join([f"    case {name} = {id};" for id, name in sorted(data_items.items())]) + "\n"

    enum_string = f"""<?php

namespace Nirbose\\PhpMcServ;

enum Material: int
{{
{cases}
}}\n"""

    with open("Material.php", "w") as file:
        file.write(enum_string)


if __name__ == "__main__":
    data = json.load(open("registries.json", "r"))
    items = data["minecraft:item"]

    for name, value in items['entries'].items():
        id = value['protocol_id']

        data_items[id] = name.replace("minecraft:", "").upper()

    create_php_enum()
    print("Material enum generated successfully.")