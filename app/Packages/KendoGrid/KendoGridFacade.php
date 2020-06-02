<?php

namespace App\Packages\KendoGrid;

use Illuminate\Support\Facades\Facade;

class KendoGridFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kendo.grid';
    }
}
