<?php

namespace App\Providers;

use App\Models\DetallePaquete;
use App\Models\Paquete;
use App\Models\TipoMercancia;
use App\Policies\DetallePaquetePolicy;
use App\Policies\PaquetePolicy;
use App\Policies\TipoMercanciaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Paquete::class => PaquetePolicy::class,
        TipoMercancia::class => TipoMercanciaPolicy::class,
        DetallePaquete::class => DetallePaquetePolicy::class
    ];

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
