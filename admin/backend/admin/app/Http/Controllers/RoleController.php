<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleUpdateAndCreateRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use DB;
use App\Common\UserService;

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
        $this->userService->allows('edit', 'users');
        $role = $request->only(['name']);
        if (Role::where('name', $role)->exists()) {
            return response()->json(['message' => 'Role already exists'],409);
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
        return response()->json(new RoleResource($role), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->userService->allows('view', 'users');
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
        $this->userService->allows('edit', 'users');
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
        return response()->json(new RoleResource($role), 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->allows('edit', 'users');
        DB::table('role_permission')->where('role_id', $id)->delete();
        Role::findOrFail($id)->delete();
        return response('Role Deleted Successfully', 204);
    }
}
