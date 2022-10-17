<?php

namespace App\Common;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AdminScope
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function handle(Request $request, Closure $next)
    {
        if($this->userService->isAdmin()) {
            return $next($request);
        }
        throw new AuthenticationException;
    }
}
