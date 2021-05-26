<?php

namespace Framework\Cache\Driver;

class MemoryDriver implements Driver
{
    private array $config = [];
    private array $cached = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function has(string $key): bool
    {
        return isset($this->cached[$key]) && $this->cached[$key]['expires'] > time();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->has($key)) {
            return $this->cached[$key]['value'];
        }

        return $default;
    }

    public function put(string $key, mixed $value, int $seconds = null): static
    {
        if (!is_int($seconds)) {
            $seconds = (int) $this->config['seconds'];
        }

        $this->cached[$key] = [
            'value' => $value,
            'expires' => time() + $seconds,
        ];

        return $this;
    }

    public function forget(string $key): static
    {
        unset($this->cached[$key]);
        return $this;
    }

    public function flush(): static
    {
        $this->cached = [];
        return $this;
    }
}
