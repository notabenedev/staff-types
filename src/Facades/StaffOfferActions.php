<?php

namespace Notabenedev\StaffTypes\Facades;

use Illuminate\Support\Facades\Facade;


/**
 *
 * Class StaffOfferActions
 * @package Notabenedev\StaffTypes\Facades
 * @method static array getArray()
 * @method static bool saveOrder(array $data)

 */
class StaffOfferActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "staff-offer-actions";
    }
}