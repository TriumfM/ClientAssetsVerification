<?php

namespace App\Http\Controllers;

use App\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $service;

    public function __construct(ClientService $clientService)
    {
        $this->service = $clientService;
    }

    public function index()
    {
        return Client::get();
    }

    public function show($id)
    {
        return Client::findOrFail($id);
    }

    public function store(Request $request)
    {
        $client = new Client();

        $client->name = $request->json("name");
        $client->iwinback_api_key = $request->json("iwinback_api_key");
        $client->iwinback_api_secret = $request->json("iwinback_api_secret");

        return  $this->service->save($client);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $client->name = $request->json("name");
        $client->iwinback_api_key = $request->json("iwinback_api_key");
        $client->iwinback_api_secret = $request->json("iwinback_api_secret");

        return $this->service->update($client);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
