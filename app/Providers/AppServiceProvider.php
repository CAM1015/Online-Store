<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    //si la sesión tiene un idioma lo aplicamos
    if (Session::has('locale')) {
        app()->setLocale(Session::get('locale'));
    } else {
        //si no se ha guardado ningún idioma se establece el predeterminado (opcional)
        app()->setLocale('en');
    }
}
}

