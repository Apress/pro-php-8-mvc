<?php

namespace Framework\Support;

use Closure;

interface DriverFactory
{
    public function addDriver(string $alias, Closure $driver): static;
    public function connect(array $config): mixed;
}
