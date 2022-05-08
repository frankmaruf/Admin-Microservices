<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Facade\FlareClient\Http\Response as HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use Symfony\Component\HttpFoundation\Response;

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
                Response::HTTP_FORBIDDEN
            );
        }
        if($user->isAdmin() && $scopes !== 'admin') {
            return response(
                [
                    'message' => 'You are not allowed to access this resource'
                ],
                Response::HTTP_FORBIDDEN
            );
        }
        $token = $user->createToken($scopes,[$scopes])->accessToken;
        // $token = $user->createToken('admin')->accessToken;
        return response()->json(['token' => $token], Response::HTTP_ACCEPTED)->withCookie('atkn', $token, 60);
    }





    public function register(RegisterRequest $request)
    {
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return response()->json(['message' => 'User already exists'], Response::HTTP_CONFLICT);
        }
        $user = User::create($request->only(['first_name', 'last_name', 'email']) + [
            'password' => bcrypt($request->input('password')),
            "is_influencer" => true,
        ]);
        return response()->json($user, Response::HTTP_CREATED);
    }




    public function user()
    {
        $user = Auth::user();
        $resource = new UserResource($user);
        if($user->isInfluencer()){
            // $resource->additional([
            //     'influencer' => new InfluencerResource($user->influencer)
            // ]);
            return $resource;
        }
        return ($resource)->additional([
            'data' => [
                'permissions' => $user->permissions(),
            ],
        ]);
    }



    public function updateInfo(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only(['first_name', 'last_name', 'email']));
        return response()->json(new UserResource($user), Response::HTTP_ACCEPTED);
    }
    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        $user = new UserResource(Auth::user());
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
        ], Response::HTTP_OK)->withCookie('atkn', $token, 60);
    }
    public function logout()
    {
        $user = Auth::user();
        // $token =  $user->tokens->pluck('id');
        // $token =  $user->tokens->pluck('id');
        // if($token){
        //     $token->each(function ($item, $key) {
        //         Token::find($item)->delete();
        //     });
        // }
        // Token::where('id', $token)->delete();
        # get user last access token
        $token = $user->tokens->last();
        # delete user last access token
        $token->delete();
        # forget cookie
        $cookie = \Cookie::forget('atkn');
        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK)->withCookie($cookie);
    }
}
