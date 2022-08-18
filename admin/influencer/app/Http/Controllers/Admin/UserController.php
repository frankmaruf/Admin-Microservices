<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminAddedEvent;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Jobs\AdminAdded;
use App\Models\User;
use App\Models\UserRole;
use App\Services\UserService;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $this->userService->allows('view', 'users');
        $users = User::paginate();
        return UserResource::collection($users);
    }
    public function show($id)
    {
        $this->userService->allows('view', 'users');
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
    public function store(UserCreateRequest $request)
    {
        $this->userService->allows('edit', 'users');
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
        // event(new AdminAddedEvent($user));
        AdminAdded::dispatch($user->email);
        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        $this->userService->allows('edit', 'users');
        $user = User::findOrFail($id);
        $user->update($request->only(['first_name', 'last_name', 'email']));
        UserRole::where('user_id', $user->id)->update([
            'role_id' => $request->input('role_id'),
        ]);
        AdminAdded::dispatch($user->email);
        return response()->json(new UserResource($user), Response::HTTP_ACCEPTED);
    }
    public function destroy($id)
    {
        $this->userService->allows('edit', 'users');
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
