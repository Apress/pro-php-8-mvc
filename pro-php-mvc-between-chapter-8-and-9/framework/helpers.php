<?php

use Framework\App;
use Framework\Validation;
use Framework\View;

if (!function_exists('app')) {
    function app(string $alias = null): mixed
    {
        if (is_null($alias)) {
            return App::getInstance();
        }

        return App::getInstance()->resolve($alias);
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = []): View\View
    {
        return app('view')->render($template, $data);
    }
}

if (!function_exists('validate')) {
    function validate(array $data, array $rules, string $sessionName = 'errors')
    {
        return app('validator')->validate($data, $rules, $sessionName);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url)
    {
        header("Location: {$url}");
        exit;
    }
}

if (!function_exists('csrf')) {
    function csrf()
    {
        $_SESSION['token'] = bin2hex(random_bytes(32));
        return $_SESSION['token'];
    }
}

if (!function_exists('secure')) {
    function secure()
    {
        if (!isset($_POST['csrf']) || !isset($_SESSION['token']) ||  !hash_equals($_SESSION['token'], $_POST['csrf'])) {
            throw new Exception('CSRF token mismatch');
        }
    }
}

if (!function_exists('dd')) {
    function dd(...$params)
    {
        var_dump(...$params);
        die;
    }
}

if (!function_exists('basePath')) {
    function basePath(string $newBasePath = null): ?string
    {
        return app('paths.base');
    }
}
