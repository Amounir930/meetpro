<?php

namespace App\Providers;

use App\Services\SystemHealth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;


/**
 * 🚫 System file: Do NOT edit, rename, or remove this class.
 * This file is critical for system health monitoring and secure handshake verification.
 * Tampering may lead to system failure or configuration corruption.
 */
class SystemTrustBindings extends ServiceProvider
{
    public function register()
    {
        // Register system trust service for global access
        $this->app->singleton(SystemHealth::class, function () {
            return new SystemHealth();
        });
    }

    public function boot()
    {
        if (file_exists(storage_path('installed')) && request()->path() != 'resolve-license' && request()->path() != 'fix-license') {
            $trustService = app(SystemHealth::class);

            // Validate system trust signature
            $fileHash = hash_file('sha256', app_path('Services/SystemHealth.php'));

            if ($fileHash !== '9dd9529446efce7cc79257e8baa3469af0b011c336025baa7d7f013aa789d611') {
                $trustService->resetNodePipeline();
            }

            if (!$trustService->syncHandshakeStatus()) {
                $trustService->terminateDispatch();
            }
        }
    }
}
