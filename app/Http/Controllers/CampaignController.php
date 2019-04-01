<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Services\CampaignService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private $service;

    public function __construct(CampaignService $campaignService)
    {
        $this->service = $campaignService;
    }

    public function index()
    {
        return Campaign::get();
    }

    public function show($id)
    {
        return Campaign::findOrFail($id);
    }

    public function store(Request $request)
    {
        $campaign = new Campaign();

        $campaign->title = $request->json("title");
        $campaign->description = $request->json("description");
        $campaign->sms_script = $request->json("sms_script");
        $campaign->call_script = $request->json("call_script");
        $campaign->email_subject = $request->json("email_subject");
        $campaign->email_html = $request->json("email_html");
        $campaign->sms_verified = $request->json("sms_verified");
        $campaign->call_verified = $request->json("call_verified");
        $campaign->email_verified = $request->json("email_verified");
        $campaign->campaign_verified = $request->json("campaign_verified");

        $campaign->brand_id = $request->json("brand_id");

        return  $this->service->save($campaign);
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $campaign->title = $request->json("title");
        $campaign->description = $request->json("description");
        $campaign->sms_script = $request->json("sms_script");
        $campaign->call_script = $request->json("call_script");
        $campaign->email_subject = $request->json("email_subject");
        $campaign->email_html = $request->json("email_html");
        $campaign->sms_verified = $request->json("sms_verified");
        $campaign->call_verified = $request->json("call_verified");
        $campaign->email_verified = $request->json("email_verified");

        $campaign->campaign_verified = $campaign->sms_verified & $campaign->call_verified &  $campaign->email_verified ? true : false;

        $campaign->brand_id = $request->json("brand_id");

        return $this->service->update($campaign);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
