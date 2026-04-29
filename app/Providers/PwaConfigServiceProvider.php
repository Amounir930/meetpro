<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PwaConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (file_exists(storage_path('installed'))) {
            config([
                'laravelpwa.manifest.icons' => [
                    '16x16' => [
                        'path' => "/storage/images/" . getSetting('FAVICON'),
                        'purpose' => 'any',
                    ],
                    '32x32' => [
                        'path' => "/storage/images/" . getSetting('FAVICON'),
                        'purpose' => 'any',
                    ],
                    '192x192' => [
                        'path' => "/storage/images/" . getSetting('FAVICON'),
                        'purpose' => 'any',
                    ],
                    '512x512' => [
                        'path' => "/storage/images/" . getSetting('FAVICON'),
                        'purpose' => 'any',
                    ],
                ],

                'laravelpwa.name' => getSetting('APPLICATION_NAME'),
                'laravelpwa.manifest.name' => getSetting('APPLICATION_NAME'),
                'laravelpwa.manifest.short_name' => getSetting('APPLICATION_NAME')
            ]);
        }
    }
}
