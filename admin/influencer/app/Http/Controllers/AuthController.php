<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AuthController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function user()
    {
        $user = $this->userService->getUser();
        $resource = new UserResource($user);
        if($user->isInfluencer()){
            $resource->additional([
                'revenue' => $this->revenue,
            ]);
            return $resource;
        }
        return ($resource)->additional([
            'data' => [
                'role' => $user->role,
                'permissions' => $user->permissions(),
            ],
        ]);
    }
    public function logout()
    {
        $user = Auth::user();
        $token = $user->tokens->last();
        # delete user last access token
        $token->delete();
        # forget cookie
        $cookie = \Cookie::forget('atkn');
        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK)->withCookie($cookie);
    }
}
