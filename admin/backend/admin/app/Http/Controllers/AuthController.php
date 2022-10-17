<?php

namespace App\Http\Controllers;

use App\Common\UserService;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;


class AuthController
{
    public function user()
    {
        return new UserResource((new UserService)->getUser());
    }
}
