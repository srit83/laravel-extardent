<?php
/**
 * @created 21.02.14 - 11:58
 * @author stefanriedel
 */

namespace Srit83\LaravelExtardent\Facades;

use Illuminate\Support\Facades\Facade;

class Builder extends Facade {
    protected static function getFacadeAccessor() { return 'builder'; }
} 