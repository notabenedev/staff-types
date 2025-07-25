<?php

namespace Notabenedev\StaffTypes\Helpers;

use App\StaffParamName;
use App\StaffParamUnit;

class StaffParamNameActionsManager
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
    protected function makeArrayData(StaffParamUnit $unit)
    {
        $names = $unit->names()->orderBy("priority")->get();

        $array = [];
        foreach ($names as $item) {
            $array[] = [
                "title" => $item->title,
                'slug' => $item->slug,
                "priority" => $item->priority,
                "id" => $item->id,
                "url" => route("admin.staff-param-names.show", ['name' => $item->slug]),
                "siteUrl" => "",
            ];
        }
        return $array;
    }


}