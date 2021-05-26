<?php

namespace Framework\Support;

use Framework\App;

abstract class DriverProvider
{
    public function bind(App $app): void
    {
        $name = $this->name();
        $factory = $this->factory();
        $drivers = $this->drivers();

        $app->bind($name, function ($app) use ($name, $factory, $drivers) {
            foreach ($drivers as $key => $value) {
                $factory->addDriver($key, $value);
            }

            $config = config($name);

            return $factory->connect($config[$config['default']]);
        });
    }

    abstract protected function name(): string;
    abstract protected function factory(): DriverFactory;
    abstract protected function drivers(): array;
}
