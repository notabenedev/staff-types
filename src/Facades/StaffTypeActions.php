<?php

namespace Notabenedev\StaffTypes\Facades;

use App\StaffType;
use Illuminate\Support\Facades\Facade;


/**
 *
 * Class StaffDepartmentActions
 * @package Notabenedev\StaffTypes\Facades
 * @method static array getAdminBreadcrumb(StaffType $type)

 */
class StaffTypeActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "staff-type-actions";
    }
}