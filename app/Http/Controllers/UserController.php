<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSaveRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index()
    {
        return User::get();
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(UserSaveRequest $request)
    {
        $user = new User();

        $user->name = $request->json('name');
        $user->email = $request->json('email');
        $user->password = bcrypt($request->json('password'));
        $user->role_id = $request->json('role_id');
        $user->active = $request->json('active');

        return $this->service->save($user);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->service->findById($id);

        $user->name = $request->json("name");
        $user->email = $request->json('email');
        $user->active = $request->json('active');
        $user->role_id = $request->json('role_id');

        if ($request->has('password')) {
            $user->password = bcrypt($request->json('password'));
        }

        return $this->service->update($user);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
