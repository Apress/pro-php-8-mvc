<?php

namespace App\Http\Controllers\Users;

use Framework\Routing\Router;

class LogInUserController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        secure();

        $data = validate($_POST, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:10'],
        ], 'login_errors');

        // use $data to find a user...

        $_SESSION['logged_in'] = true;

        return redirect($this->router->route('show-home-page'));
    }
}
