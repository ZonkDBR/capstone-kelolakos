<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\LokasiKos;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('template.main', function ($view) {
            $currentLocationId = session('current_location_id');
            $locations = LokasiKos::all();
    
            $view->with([
                'locations' => $locations,
            ]);
        });
    }
}
