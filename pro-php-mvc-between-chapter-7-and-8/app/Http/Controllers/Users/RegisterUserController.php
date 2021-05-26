<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Framework\Routing\Router;

class RegisterUserController
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:10'],
        ], 'register_errors');

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->save();

        $_SESSION['registered'] = true;

        return redirect($this->router->route('show-home-page'));
    }
}
