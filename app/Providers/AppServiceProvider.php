<?php

namespace App\Providers;

use App\Interfaces\Settings\SettingInterface;
use App\Interfaces\Treasuries\TreasuryInterface;
use App\Repositories\Settings\SettingRepository;
use App\Repositories\Treasuries\TreasuryRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
