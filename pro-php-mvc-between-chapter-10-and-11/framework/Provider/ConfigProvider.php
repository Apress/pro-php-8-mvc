<?php

namespace Framework\Provider;

use Framework\App;
use Framework\Support\Config;

class ConfigProvider
{
    public function bind(App $app): void
    {
        $app->bind('config', function($app) {
            return new Config();
        });
    }
}
