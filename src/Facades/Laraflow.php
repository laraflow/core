<?php

namespace Laraflow\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraflow\Core\Laraflow
 */
class Laraflow extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laraflow';
    }
}
