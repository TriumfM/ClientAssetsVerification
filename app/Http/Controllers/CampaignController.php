<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Requests\CampaignSaveRequest;
use App\Http\Requests\CampaignUpdateRequest;
use App\Services\CampaignService;

class CampaignController extends Controller
{
    private $service;

    public function __construct(CampaignService $campaignService)
    {
        $this->service = $campaignService;
    }

    public function index()
    {
        return $this->service->findAll();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(CampaignSaveRequest $request)
    {
        $campaign = new Campaign();

        $campaign->title = $request->json("title");
        $campaign->description = $request->json("description");
        $campaign->sms_script = $request->json("sms_script");
        $campaign->call_script = $request->json("call_script");
        $campaign->email_subject = $request->json("email_subject");
        $campaign->email_html = $request->json("email_html");

        $campaign->brand_id = $request->json("brand_id");

        return  $this->service->save($campaign);
    }

    public function update(CampaignUpdateRequest $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $campaign->title = $request->json("title");
        $campaign->description = $request->json("description");
        if(!$campaign->sms_verified)
            $campaign->sms_script = $request->json("sms_script");
        if(!$campaign->call_verified)
            $campaign->call_script = $request->json("call_script");
        if(!$campaign->email_verified) {
            $campaign->email_subject = $request->json("email_subject");
            $campaign->email_html = $request->json("email_html");
        }
        $campaign->sms_verified = $request->json("sms_verified");
        $campaign->call_verified = $request->json("call_verified");
        $campaign->email_verified = $request->json("email_verified");

        $campaign->campaign_verified = $campaign->sms_verified & $campaign->call_verified &  $campaign->email_verified ? true : false;

        $campaign->brand_id = $request->json("brand_id");
        $campaign->client_id = $request->json("client_id");

        return $this->service->update($campaign);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function getByClientId($client_id)
    {
        return Campaign::with('client')->where('client_id', $client_id)->get();
    }

    public function getByBrandId($brand_id)
    {
        return Campaign::with('brand')->where('brand_id', $brand_id)->get();
    }
}
