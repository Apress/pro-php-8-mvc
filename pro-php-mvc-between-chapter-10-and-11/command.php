<?php

require __DIR__ . '/vendor/autoload.php';

$app = \Framework\App::getInstance();
$app->bind('paths.base', fn() => __DIR__);

$console = new \Symfony\Component\Console\Application();

$commands = require __DIR__ . '/app/commands.php';

foreach ($commands as $command) {
    $console->add(new $command);
}

$console->run();
