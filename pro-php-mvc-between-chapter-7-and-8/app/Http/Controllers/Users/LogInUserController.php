<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
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

        $user = User::where('email', $data['email'])->first();

        if ($user && password_verify($data['password'], $user->password)) {
            $_SESSION['user_id'] = $user->id;
        }

        return redirect($this->router->route('show-home-page'));
    }
}
