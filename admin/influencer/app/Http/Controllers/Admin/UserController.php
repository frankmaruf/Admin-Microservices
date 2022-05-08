<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

class UserController
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
        $user = User::create($request->only(['first_name', 'last_name', 'email']) + [
            'password' => bcrypt(123456),
        ]);
        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->input('role_id'),
        ]);
        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        Gate::authorize('edit', 'users');
        $user = User::findOrFail($id);
        $user->update($request->only(['first_name', 'last_name', 'email']));
        UserRole::where('user_id', $user->id)->update([
            'role_id' => $request->input('role_id'),
        ]);
        return response()->json(new UserResource($user), Response::HTTP_ACCEPTED);
    }
    public function destroy($id)
    {
        Gate::authorize('edit', 'users');
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
