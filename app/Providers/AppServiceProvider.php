<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Contracts\Excel\ExcelSaveDataServiceInterface;
use \App\Contracts\Excel\ExcelMapDataServiceInterface;
use \App\Contracts\Excel\ExcelValidateServiceInterface;
use \App\Contracts\Excel\ExcelSaveDataRepositoryInterface;
use \App\Service\ExcelSaveDataService;
use \App\Service\ExcelMapDataService;
use \App\Service\ExcelValidateService;
use \App\Repository\ExcelSaveDataRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExcelSaveDataServiceInterface::class, ExcelSaveDataService::class);
        $this->app->singleton(ExcelMapDataServiceInterface::class, ExcelMapDataService::class);
        $this->app->singleton(ExcelValidateServiceInterface::class, ExcelValidateService::class);
        $this->app->singleton(ExcelSaveDataRepositoryInterface::class, ExcelSaveDataRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
