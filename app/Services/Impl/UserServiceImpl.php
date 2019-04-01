<?php

namespace App\Services\Impl;


use App\Services\UserService;
use App\User;

class UserServiceImpl implements UserService
{


    /**
     * Find All
     *
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        return User::get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Save new
     *
     * @param User $user
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(User $user)
    {
        $user->save();

        return $user;
    }

    /**
     * Update by id
     *
     * @param User $user
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(User $user)
    {
        $user->update();

        return $user;
    }

    /**
     * Delete
     *
     * @param $id
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }
}