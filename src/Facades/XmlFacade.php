<?php


namespace Laraflow\Core\Facades;


use Illuminate\Support\Facades\Facade;
use Laraflow\Core\Http\Response\XmlResponse;

class XmlFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'xml';
    }
}
