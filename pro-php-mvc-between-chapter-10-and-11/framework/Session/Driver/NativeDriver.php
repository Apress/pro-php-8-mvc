<?php

namespace Framework\Session\Driver;

class NativeDriver implements Driver
{
    private array $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function has(string $key): bool
    {
        $prefix = $this->config['prefix'];
        return isset($_SESSION["{$prefix}{$key}"]);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $prefix = $this->config['prefix'];

        if (isset($_SESSION["{$prefix}{$key}"])) {
            return $_SESSION["{$prefix}{$key}"];
        }

        return $default;
    }

    public function put(string $key, mixed $value): static
    {
        $prefix = $this->config['prefix'];
        $_SESSION["{$prefix}{$key}"] = $value;
        return $this;
    }

    public function forget(string $key): static
    {
        $prefix = $this->config['prefix'];
        unset($_SESSION["{$prefix}{$key}"]);
        return $this;
    }

    public function flush(): static
    {
        session_reset();
        return $this;
    }
}
