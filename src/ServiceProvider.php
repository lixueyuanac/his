<?php

namespace His;

use His\His;
use his\Pay;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Isp::class, function(){
            return new Isp();
        });
        $this->app->alias(Isp::class, 'isp');
    }

    public function provides()
    {
        return [Isp::class, 'isp'];
    }
}