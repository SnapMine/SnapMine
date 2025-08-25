<?php

namespace SnapMine;

use Symfony\Component\Yaml\Yaml;

class ServerConfig
{
    private mixed $config;

    public function __construct(private readonly string $file)
    {
        $this->config = Yaml::parseFile($file);
    }

    public function get(string $key): mixed
    {
        return $this->config[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, mixed $value): void
    {
        $this->config[$key] = $value;

        $yaml = Yaml::dump($this->config);

        file_put_contents($this->file, $yaml);
    }

    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }
}