<?php

namespace Modules\Boletofacil\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BoletoFacilServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/boletofacil.php' => config_path('boletofacil.php'),
        ], 'config');    
    }

    public function register()
    {
        //
    }
}