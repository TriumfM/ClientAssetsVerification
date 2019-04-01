<?php

namespace App\Services\Impl;


use App\Campaign;
use App\Services\CampaignService;

class CampaignServiceImpl implements CampaignService
{

    /**
     * Find All
     *
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        return Campaign::get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Campaign::findOrFail($id);
    }

    /**
     * Save new
     *
     * @param Campaign $campaign
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Campaign $campaign)
    {
        $campaign->save();

        return $campaign;
    }

    /**
     * Update by id
     *
     * @param Campaign $campaign
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Campaign $campaign)
    {
        $campaign->update();

        return $campaign;
    }

    /**
     * Delete
     *
     * @param $id
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        $campaign = Campaign::findOrFail($id);

        $campaign->delete();
    }
}