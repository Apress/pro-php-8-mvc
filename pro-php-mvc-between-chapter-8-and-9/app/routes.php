<?php

use App\Http\Controllers\ShowHomePageController;
use App\Http\Controllers\Products\OrderProductController;
use App\Http\Controllers\Products\ShowProductController;
use App\Http\Controllers\Users\LogInUserController;
use App\Http\Controllers\Users\LogOutUserController;
use App\Http\Controllers\Users\RegisterUserController;
use App\Http\Controllers\Users\ShowRegisterFormController;
use Framework\Routing\Router;

return function(Router $router) {
    $router->errorHandler(
        404, fn() => 'whoops!'
    );

    $router->add(
        'GET', '/',
        [ShowHomePageController::class, 'handle'],
    )->name('show-home-page');

    $router->add(
        'GET', '/products/view/{product}',
        [ShowProductController::class, 'handle'],
    )->name('view-product');

    $router->add(
        'POST', '/products/order/{product}',
        [OrderProductController::class, 'handle'],
    )->name('order-product');

    $router->add(
        'GET', '/register',
        [ShowRegisterFormController::class, 'handle'],
    )->name('show-register-form');

    $router->add(
        'POST', '/register',
        [RegisterUserController::class, 'handle'],
    )->name('register-user');

    $router->add(
        'POST', '/log-in',
        [LogInUserController::class, 'handle'],
    )->name('log-in-user');

    $router->add(
        'GET', '/log-out',
        [LogOutUserController::class, 'handle'],
    )->name('log-out-user');
};
