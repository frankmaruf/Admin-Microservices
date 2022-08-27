<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        return PaginatedResource::collection(User::paginate());
    }
    public function show($id){
        return User::find($id);
    }
    public function store(Request $request){
        $data = $request->only(['first_name', 'last_name', 'email']) + [
            'password' => bcrypt($request->input("password")),
        ];
        $user = User::create($data);
        return response($user,Response::HTTP_CREATED);
    }
    public function update(Request $request,$id){
        $user = User::findOrFail($id);
        $data = $request->only(['first_name', 'last_name', 'email']);
        $user->update($request->only($data));
        return response($user,Response::HTTP_ACCEPTED);
    }
    public function destroy($id)
    {
        $this->userService->allows('edit', 'users');
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
