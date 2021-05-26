<?php

namespace Framework\Database;

use Closure;
use Framework\Database\Connection\Connection;
use Framework\Database\Exception\ConnectionException;
use Framework\Support\DriverFactory;

class Factory implements DriverFactory
{
    protected array $drivers;

    public function addDriver(string $alias, Closure $driver): static
    {
        $this->drivers[$alias] = $driver;
        return $this;
    }

    public function connect(array $config): Connection
    {
        if (!isset($config['type'])) {
            throw new ConnectionException('type is not defined');
        }

        $type = $config['type'];

        if (isset($this->drivers[$type])) {
            return $this->drivers[$type]($config);
        }

        throw new ConnectionException('unrecognised type');
    }
}
