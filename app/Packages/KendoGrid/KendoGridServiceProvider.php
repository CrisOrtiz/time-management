<?php

namespace App\Packages\KendoGrid;

use Illuminate\Support\ServiceProvider;

class KendoGridServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('kendo.grid', function () {
            return new KendoGrid();
        });
    }
}
