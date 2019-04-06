<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSaveRequest;
use App\Http\Requests\UserUpdateRequest;
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

        return $this->service->update($user);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
