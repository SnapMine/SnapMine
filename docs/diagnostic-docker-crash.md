# Diagnostic crash Docker (21/11/2026)

## Symptôme
`docker start mon-app` → container `Exited (139)` immédiatement, aucun log
(139 = SIGSEGV).

## Analyse (bissection dans le container)
1. `php-cli -v` → OK (PHP 8.6.0 ZTS)
2. `require vendor/autoload.php` → OK
3. `server()` (helpers.php) → **segfault**
4. Décomposition de `new Server()` : EventManager OK, BlockStateLoader OK,
   ServerConfig OK, Registry::load OK, ChunkManager OK, CommandManager OK
5. `new World(...)` → `double free or corruption (!prev)` au chargement de
   `resources/worlds/New_World`
6. `new Region(...)` → `Amp\Parallel\Worker\createWorker()` → **segfault**
7. Sur l'hôte (PHP 8.5.4) : `createWorker()` fonctionne → l'extension PHP est
   le facteur déterminant.

## Cause racine
Le Dockerfile utilisait `FROM dunglas/frankenphp` (tag flottant). La base a été
mise à jour le 19/11/2026 et embarque désormais **PHP 8.6.0**. `amphp/parallel`
(segfault dans le spawn du worker) ne supporte pas encore cette version.
Le rebuild de l'image a donc fait passer le serveur de PHP 8.5 → 8.6 sans
changement de code.

## Correctif
`Dockerfile` : `FROM dunglas/frankenphp:1.14.0-php8.5`
(épingler version FrankenPHP + version PHP pour la reproductibilité).

## Relancer
```
docker build -t snapmine .
docker rm mon-app
docker run -d --name mon-app -p 25565:25565 snapmine
```
