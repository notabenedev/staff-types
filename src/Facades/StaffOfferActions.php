<?php

namespace Notabenedev\StaffTypes\Facades;

use Illuminate\Support\Facades\Facade;


/**
 *
 * Class StaffOfferActions
 * @package Notabenedev\StaffTypes\Facades
 * @method static array getArray()

 */
class StaffOfferActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "staff-offer-actions";
    }
}