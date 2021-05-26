<?php

namespace App\Http\Controllers\Users;

use Framework\Routing\Router;

class ShowRegisterFormController
{
    public function handle(Router $router)
    {
        return view('users/register', [
            'registerAction' => $router->route('register-user'),
            'logInAction' => $router->route('log-in-user'),
            'csrf' => csrf(),
        ]);
    }
}
