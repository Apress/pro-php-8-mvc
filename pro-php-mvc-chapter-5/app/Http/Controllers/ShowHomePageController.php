<?php

namespace App\Http\Controllers;

class ShowHomePageController
{
    public function handle()
    {
        return view('home', ['number' => 42]);
    }
}
