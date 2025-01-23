<?php

namespace App\Providers;

use App\Services\CompanyDataCaptureService;
use App\Services\CompanyDataParser;
use App\Services\DataCaptureServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DataCaptureServiceInterface::class, function ($app) {
            return new CompanyDataCaptureService(new Client(), new CompanyDataParser());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
