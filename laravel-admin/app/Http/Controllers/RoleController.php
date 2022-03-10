<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleUpdateAndCreateRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleUpdateAndCreateRequest $request)
    {
        $role = $request->only(['name']);
        if(Role::where('name', $role)->exists()) {
            return response()->json(['message' => 'Role already exists'], Response::HTTP_CONFLICT);
        }
        $role = Role::create($role);
        return response()->json($role, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Role::findOrFail(
            $id
        );
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
        $role = Role::findOrFail($id);
        $role->update($request->only(['name']));
        return response()->json($role, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return response('Role Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
