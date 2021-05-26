<?php

namespace App\Http\Controllers\Users;

use Framework\Routing\Router;

class ShowRegisterFormController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        return view('users/register', [
            'registerAction' => $this->router->route('register-user'),
            'logInAction' => $this->router->route('log-in-user'),
            'csrf' => csrf(),
        ]);
    }
}
