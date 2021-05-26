<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = \Framework\App::getInstance();
$app->bind('paths.base', fn() => __DIR__ . '/..');
