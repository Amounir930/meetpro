<?php

use PHPUnit\Event\Telemetry\System;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\MailConfigServiceProvider::class,
    App\Providers\PwaConfigServiceProvider::class,
    Froiden\LaravelInstaller\Providers\LaravelInstallerServiceProvider::class,
    App\Providers\SystemTrustBindings::class,    
    App\Providers\RouteServiceProvider::class
];
