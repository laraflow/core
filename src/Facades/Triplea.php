<?php

namespace Laraflow\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraflow\Core\Triplea
 */
class Triplea extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'triplea';
    }
}
