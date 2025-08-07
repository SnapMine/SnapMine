# php-minecraft-server

The goal of this project is to recreate a custom and lightweight Minecraft server, designed to enable the creation of concept servers (minigames, skyblock, etc.).  
It aims to provide a flexible and modular foundation to quickly develop custom Minecraft experiences, without the overhead of classic world generation.

> **Note:** This server does not include built-in world generation. It is ideal for controlled environments, fixed maps, or specific game concepts.


## Features

- Read and write Minecraft Java Edition network protocol
- Entity, player, event, and packet management
- Region and chunk system based on the MCA format
- Configuration support via registry data packs
- Modular architecture (plugins, components, managers, etc.)

## Project Structure

- `src/`: Main source code (server, entities, packets, utilities, etc.)
- `plugins/`: Custom plugins
- `resources/`: Registry data and other resources
- `gen_scripts/`: Automatic generation scripts (Python)
- `tests/`: Unit and integration tests
- `mca-test/`: Test files for regions/chunks

## Quick Start

1. **Install dependencies:**
   ```sh
   composer install
   ```

2. **Start the server:**
   ```sh
   php server.php
   ```

## Tests

Run tests with PHPUnit or Pest:
```sh
vendor/bin/phpunit
# or
vendor/bin/pest
```

## License

This project is licensed under the [Apache 2.0](LICENSE) license.