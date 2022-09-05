<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Jobs\AdminAdded;
use App\Models\UserRole;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $this->userService->allows('view', 'users');
        return $this->userService->all($request->input('page',1));
    }
    public function show($id)
    {
        $this->userService->allows('view', 'users');
        $user = $this->userService->get($id);
        return new UserResource($user);
    }
    public function store(UserCreateRequest $request)
    {
        $this->userService->allows('edit', 'users');
        $email = $request->input('email');
        $data = $request->only(['first_name', 'last_name', 'email']) + [
            'password' => 123456,
        ];
        $user = $this->userService->create($data);
        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $request->input('role_id'),
        ]);
        AdminAdded::dispatch($user->email);
        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        $this->userService->allows('edit', 'users');
        $data = $request->only(['first_name', 'last_name', 'email']);
        $user = $this->userService->update($id,$data);
        UserRole::where('user_id', $user->id)->update([
            'role_id' => $request->input('role_id'),
        ]);
        return response()->json(new UserResource($user), Response::HTTP_ACCEPTED);
    }
    public function destroy($id)
    {
        $this->userService->allows('edit', 'users');
        $this->userService->delete($id);
        return response('Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
