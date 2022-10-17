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
    public function logout()
    {
        $user = Auth::user();
        $token = $user->tokens->last();
        # delete user last access token
        $token->delete();
        # forget cookie
        $cookie = \Cookie::forget('atkn');
        return response()->json(['message' => 'Successfully logged out'], 200)->withCookie($cookie);
    }
}
