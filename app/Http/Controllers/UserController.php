<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSaveRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Role;
use App\Services\UserService;
use App\User;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index()
    {
        return $this->service->findAll();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(UserSaveRequest $request)
    {
        $user = new User();

        $user->first_name = $request->json("first_name");
        $user->last_name = $request->json("last_name");
        $user->username = $request->json("username");
        $user->email = $request->json('email');
        $user->password = bcrypt($request->json('password'));
        $user->active = $request->json('active');

        $user->role_id = $this->checkRoleId($request->json('role'));
        if($user->role_id == null)
            return response(['errors'=>['general'=>['Role does not exist.']]], 422);

        return $this->service->save($user);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->first_name = $request->json("first_name");
        $user->last_name = $request->json("last_name");
        $user->username = $request->json("username");
        $user->email = $request->json('email');
        $user->active = $request->json('active');

        if ($request->has('password')) {
            $user->password = bcrypt($request->json('password'));
        }

        $user->role_id = $this->checkRoleId($request->json('role'));
        if($user->role_id == null)
            return response(['errors'=>['general'=>['Role does not exist.']]], 422);

        return $this->service->update($user);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    private function checkRoleId($role_id)
    {
        if($role_id == 1 && \Auth::user()->role_id != 1)
            return null;

        $userRole = Role::find($role_id);
        if($userRole == null)
            return $userRole;

        return $role_id;
    }
}
