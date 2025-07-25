<?php

namespace Notabenedev\StaffTypes\Facades;

use App\StaffDepartment;
use App\StaffParamUnit;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Notabenedev\StaffTypes\Helpers\StaffParamUnitActionsManager;

/**
 *
 * Class StaffParamUnitActions
 * @package Notabenedev\StaffTypes\Facades
 * @method static array getArray()
 * @method static  bool canChangeClass(StaffParamUnit $unit, $newClass)
 * @method static  array|bool diffChangeTypes(StaffParamUnit $unit, $userInput)
 * @method static array getAdminBreadcrumb(StaffParamUnit $unit)

 */
class StaffParamUnitActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "staff-param-unit-actions";
    }
}