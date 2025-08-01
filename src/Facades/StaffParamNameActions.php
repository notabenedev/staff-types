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
 * Class StaffParamNameActions
 * @package Notabenedev\StaffTypes\Facades
 * @method static array getArray()

 */
class StaffParamNameActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "staff-param-name-actions";
    }
}