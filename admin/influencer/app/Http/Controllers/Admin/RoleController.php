<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleUpdateAndCreateRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\UserService;
use DB;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $this->userService->allows('view', 'users');
        return RoleResource::collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleUpdateAndCreateRequest $request)
    {
        Gate::authorize('edit', 'users');
        $role = $request->only(['name']);
        if (Role::where('name', $role)->exists()) {
            return response()->json(['message' => 'Role already exists'], Response::HTTP_CONFLICT);
        }
        $role = Role::create($role);
        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permission_id) {
                DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }
        return response()->json(new RoleResource($role), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('view', 'users');
        return new RoleResource(Role::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateAndCreateRequest $request, $id)
    {
        Gate::authorize('edit', 'users');
        $role = Role::findOrFail($id);
        $name = $request->only(['name']);
        $role->update($name);
        DB::table('role_permission')->where('role_id', $role->id)->delete();
        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permission_id) {
                DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }
        return response()->json(new RoleResource($role), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('edit', 'users');
        DB::table('role_permission')->where('role_id', $id)->delete();
        Role::findOrFail($id)->delete();
        return response('Role Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
