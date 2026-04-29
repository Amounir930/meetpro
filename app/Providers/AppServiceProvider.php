<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once base_path() . "/system/apl_core_configuration.php";
        require_once base_path() . "/system/apl_core_functions.php";
        require_once base_path() . "/system/aus_core_configuration.php";
        require_once base_path() . "/system/aus_core_functions.php";
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Activity::saving(function (Activity $activity) {
            $activity->ip = request()->ip();
        });
    }
}
