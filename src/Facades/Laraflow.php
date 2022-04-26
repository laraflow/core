<?php

namespace Laraflow\Laraflow\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraflow\Laraflow\Laraflow
 */
class Laraflow extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laraflow';
    }
}
