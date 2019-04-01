<?php

namespace App\Services\Impl;


use App\Client;
use App\Services\ClientService;

class ClientServiceImpl implements ClientService
{

    /**
     * Find All
     *
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        return Client::get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Client::findOrFail($id);
    }

    /**
     * Save new
     *
     * @param Client $client
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Client $client)
    {
        $client->save();

        return $client;
    }

    /**
     * Update by id
     *
     * @param Client $client
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Client $client)
    {
        $client->update();

        return $client;
    }

    /**
     * Delete
     *
     * @param $id
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        $client = Client::findOrFail($id);

        $client->delete();
    }
}