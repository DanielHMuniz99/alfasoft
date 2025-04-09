<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\CountryServiceInterface;
use App\Interfaces\AvatarServiceInterface;
use App\Services\RestCountriesService;
use App\Services\UiAvatarService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CountryServiceInterface::class, RestCountriesService::class);
        $this->app->bind(AvatarServiceInterface::class, UiAvatarService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (!app()->runningInConsole()) {
            Auth::loginUsingId(1);
        }
    }
}
