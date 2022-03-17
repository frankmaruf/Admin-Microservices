<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return [
                'message' => 'Invalid credentials'
            ];
        }
        $user = Auth::user();
        $token = $user->createToken('admin',)->accessToken;
        return response()->json(['token' => $token], 401)->withCookie('atkn', $token, 60);
    }
    public function register(RegisterRequest $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return response()->json(['message' => 'User already exists'], Response::HTTP_CONFLICT);
        }
        $user = User::create($request->only(['first_name', 'last_name', 'email']) + [
            'password' => bcrypt($request->input('password')),
            'role_id' => 1,
        ]);
        return response()->json($user, Response::HTTP_CREATED);
    }
    public function logout()
    {
        $user = Auth::user();
        $token =  $user->tokens->pluck('id');
        Token::where('id', $token)->delete();
        $cookie = \Cookie::forget('atkn');
        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK)->withCookie($cookie);
    }
}
