<?php

namespace Notabenedev\StaffTypes\Facades;

use Illuminate\Support\Facades\Facade;


/**
 *
 * Class StaffParamActions
 * @package Notabenedev\StaffTypes\Facades
 * @method static array prepareAvailableData(string $model)
 * @method static array getArray()
 * @method static void availableClearCache($modelObject)
 * @method static void availableClearCacheAll()

 */
class StaffParamActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "staff-param-actions";
    }
}