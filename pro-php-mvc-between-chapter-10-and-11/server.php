<?php

$path = __DIR__;
$separator = DIRECTORY_SEPARATOR;
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if (is_file("{$path}{$separator}public{$separator}{$uri}")) {
    return false;
}

require_once "{$path}{$separator}public{$separator}index.php";
