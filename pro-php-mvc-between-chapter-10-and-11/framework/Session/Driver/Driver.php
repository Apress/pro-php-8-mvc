<?php

namespace Framework\Session\Driver;

interface Driver
{
    /**
     * Tell if a value is session
     */
    public function has(string $key): bool;

    /**
     * Get a session value
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Put a value into the session
     */
    public function put(string $key, mixed $value): static;

    /**
     * Remove a single session value
     */
    public function forget(string $key): static;

    /**
     * Remove all session values
     */
    public function flush(): static;
}
