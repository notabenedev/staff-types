<?php

namespace Notabenedev\StaffTypes\Helpers;

use App\StaffEmployee;
use App\StaffOffer;


class StaffOfferActionsManager
{

    /**
     * Получить массив.
     *
     * @return array
     *
     */
    public function getArray()
    {
        $array = $this->makeArrayData();
        return $array;
    }



    /**
     * Получить данные в массив
     *
     * @return array
     */
    protected function makeArrayData(StaffEmployee $employee)
    {
        $offers = $employee->offers()->orderBy("priority")->get();

        $array = [];
        foreach ($offers as $item) {
            $array[] = [
                "title" => $item->title,
                'slug' => $item->slug,
                "priority" => $item->priority,
                "id" => $item->id,
                "url" => route("admin.staff-offers.show", ['offer' => $item->slug]),
                "siteUrl" => "",
            ];
        }
        return $array;
    }
}