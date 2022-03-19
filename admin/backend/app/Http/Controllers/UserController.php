<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('view', 'users');
        $users = User::paginate();
        return UserResource::collection($users);
    }
    public function show($id)
    {
        Gate::authorize('view', 'users');
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
    public function store(UserCreateRequest $request)
    {
        Gate::authorize('edit', 'users');
        $email = $request->input('email');
        if (User::where('email', $email)->exists()) {
            return response()->json(['message' => 'User already exists'], Response::HTTP_CONFLICT);
        }
        $user = User::create($request->only(['first_name', 'last_name', 'email','role_id']) + [
            'password' => bcrypt(123456),
        ]);
        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        Gate::authorize('edit', 'users');
        $user = User::findOrFail($id);
        $user->update($request->only(['first_name', 'last_name', 'email','role_id']));
        return response()->json(new UserResource($user), Response::HTTP_ACCEPTED);
    }
    public function destroy($id)
    {
        Gate::authorize('edit', 'users');
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
    public function user()
    {
        $user = Auth::user();
        return (new UserResource($user))->additional([
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
}
