<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $service;

    public function __construct(BrandService $brandService)
    {
        $this->service = $brandService;
    }

    public function index()
    {
        return Brand::get();
    }

    public function show($id)
    {
        return Brand::findOrFail($id);
    }

    public function store(Request $request)
    {
        $brand = new Brand();

        $brand->name = $request->json("name");
        $brand->client_id = $request->json("client_id");

        return  $this->service->save($brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $brand->name = $request->json("name");
        $brand->client_id = $request->json("client_id");

        return $this->service->update($brand);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
