<?php

namespace App\Services\Impl;


use App\Campaign;
use App\Filters\ApiRequest;
use App\Filters\FilterConstants;
use App\Services\CampaignService;

class CampaignServiceImpl implements CampaignService
{
    private $allowFilters = [];
    private $allowIncludes = FilterConstants::CAMPAIGN_INCLUDES;
    /**
     * Find All
     *
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        $campaings = ApiRequest::applyQuery($this->allowFilters,$this->allowIncludes,Campaign::class)->get();
        return $campaings;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        Campaign::findOrFail($id);
        return ApiRequest::applyQuery([],$this->allowIncludes,Campaign::class)
            ->where('id',$id)
            ->first();
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