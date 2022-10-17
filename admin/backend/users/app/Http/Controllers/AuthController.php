<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class AuthController
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
        $scopes = $request->input('scopes');
        if($user->isInfluencer() && $scopes !== 'influencer') {
            return response(
                [
                    'message' => 'You are not allowed to access this resource'
                ],
                403
            ); 
        }
        if($user->isAdmin() && $scopes !== 'admin') {
            return response(
                [
                    'message' => 'You are not allowed to access this resource'
                ],
                403
            );
        }
        $token = $user->createToken($scopes,[$scopes])->accessToken;
        // $token = $user->createToken('admin')->accessToken;
        return response()->json(['token' => $token], 202)->withCookie('atkn', $token, 60);
    }





    public function register(RegisterRequest $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return response()->json(['message' => 'User already exists'], 409);
        }
        $user = User::create($request->only(['first_name', 'last_name', 'email']) + [
            'password' => bcrypt($request->input('password')),
            "is_influencer" => 1,
        ]);
        return response()->json($user, 201);
    }




    public function user()
    {
        return Auth::user();
    }



    public function updateInfo(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only(['first_name', 'last_name', 'email']));
        return response()->json($user, 202);
    }
    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update(['password' => bcrypt($request->input('password'))]);
        $userid = $user->id;
        $token = Token::where('user_id', $userid);
        // $refreshToken = RefreshToken::where('user_id', $userid);
        $token->delete();
        // $refreshToken->delete();
        $token = $user->createToken('admin',)->accessToken;
        return response()->json([
            'message' => 'Successfully updated password',
            'token' => $token
        ], 200)->withCookie('atkn', $token, 60);
    }
    public function authenticated()
    {
        return 1;
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
