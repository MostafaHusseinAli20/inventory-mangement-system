<?php

namespace App\Providers;

use App\Interfaces\SalesMatrialTypes\SalesMatrialTypeInterface;
use App\Interfaces\Settings\SettingInterface;
use App\Interfaces\Stores\StoreInterface;
use App\Interfaces\Treasuries\TreasuryInterface;
use App\Interfaces\Uoms\InvUomInterface;
use App\Repositories\SalesMatrialTypes\SalesMatrialTypeRepository;
use App\Repositories\Settings\SettingRepository;
use App\Repositories\Stores\StoreRepository;
use App\Repositories\Treasuries\TreasuryRepository;
use App\Repositories\Uoms\InvUomRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SettingInterface::class, SettingRepository::class);
        $this->app->bind(TreasuryInterface::class, TreasuryRepository::class);
        $this->app->bind(SalesMatrialTypeInterface::class, SalesMatrialTypeRepository::class);
        $this->app->bind(StoreInterface::class, StoreRepository::class);
        $this->app->bind(InvUomInterface::class, InvUomRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
