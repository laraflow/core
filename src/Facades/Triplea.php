<?php

namespace Laraflow\Laraflow\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraflow\Laraflow\Triplea
 */
class Triplea extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'triplea';
    }
}
