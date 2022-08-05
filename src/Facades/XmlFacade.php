<?php

namespace Laraflow\Core\Facades;

use Illuminate\Support\Facades\Facade;

class XmlFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'xml';
    }
}
