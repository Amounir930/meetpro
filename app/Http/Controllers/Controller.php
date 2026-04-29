<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\SystemHealth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        if (file_exists(storage_path('installed')) && request()->path() !== 'resolve-license' && request()->path() !== 'fix-license') {
            $trustService = app(SystemHealth::class);

            $hash = hash_file('sha256', app_path('Providers/SystemTrustBindings.php'));

            if ($hash != '5c9ac19d007ec3d4d77a372b0ecdd4a23243462e300f3caddc867a0f1583c548') {
                $trustService->resetNodePipeline();
            }

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
