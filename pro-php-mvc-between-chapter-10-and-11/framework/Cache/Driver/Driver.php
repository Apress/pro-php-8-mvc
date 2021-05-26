<?php

namespace Framework\Cache\Driver;

interface Driver
{
    /**
     * Tell if a value is cached (still)
     */
    public function has(string $key): bool;

    /**
     * Get a cached value
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Put a value into the cache, for an optional number of seconds
     */
    public function put(string $key, mixed $value, int $seconds = null): static;

    /**
     * Remove a single cached value
     */
    public function forget(string $key): static;

    /**
     * Remove all cached values
     */
    public function flush(): static;
}
