<?php

namespace App\Services\Impl;

use App\Brand;

class BrandServiceImpl
{
    /**
     * Find All
     *
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        return Brand::get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Brand::findOrFail($id);
    }

    /**
     * Save new
     *
     * @param Brand $brand
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Brand $brand)
    {
        $brand->save();

        return $brand;
    }

    /**
     * Update by id
     *
     * @param Brand $brand
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Brand $brand)
    {
        $brand->update();

        return $brand;
    }

    /**
     * Delete
     *
     * @param $id
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();
    }
}