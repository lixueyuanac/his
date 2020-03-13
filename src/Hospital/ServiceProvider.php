<?php

namespace Hospital;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
class ServiceProvider extends LaravelServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Factory::class, function(){
            return new Factory();
        });
        $this->app->alias(Factory::class, 'isp');
    }

    public function provides()
    {
        return [Factory::class, 'isp'];
    }
}