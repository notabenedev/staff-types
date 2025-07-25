<?php

namespace Notabenedev\StaffTypes\Listeners;


use Portedcheese\BaseSettings\Events\PriorityUpdate;
use Notabenedev\StaffTypes\Facades\StaffParamActions;

class AvailableParamsClearCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PriorityUpdate $event)
    {
        $table = $event->table;
        // Очистить список id категорий.
        if ($table === "staff_param_units" || $table === "staff_param_names" || $table === "staff_offers")
            StaffParamActions::availableClearCacheAll();
    }
}
