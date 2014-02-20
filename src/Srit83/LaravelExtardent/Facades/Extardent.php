<?php
/**
 * @created 20.02.14 - 21:15
 * @author stefanriedel
 */

namespace Srit83\LaravelExtardent\Facades;

use Illuminate\Support\Facades\Facade;

class Extardent extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'extardent'; }

}