<?php

namespace App\Providers;

use App\Services\BrandService;
use App\Services\CampaignService;
use App\Services\ClientService;
use App\Services\Impl\BrandServiceImpl;
use App\Services\Impl\CampaignServiceImpl;
use App\Services\Impl\ClientServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientService::class,ClientServiceImpl::class);
        $this->app->bind(BrandService::class,BrandServiceImpl::class);
        $this->app->bind(CampaignService::class,CampaignServiceImpl::class);
        $this->app->bind(UserService::class,UserServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
