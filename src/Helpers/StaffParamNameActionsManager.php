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
     * Сохранить порядок.
     *
     * @param array $data
     * @return bool
     */
    public function saveOrder(array $data)
    {
        try {
            $this->setItemsWeight($data, 0);
        }
        catch (\Exception $exception) {
            return false;
        }
        return true;
    }


    /**
     * Задать порядок.
     *
     * @param array $items
     *
     */
    protected function setItemsWeight(array $items)
    {
        foreach ($items as $priority => $item) {
            $id = $item["id"];
            // Обновление
            $name = StaffParamName::query()
                ->where("id", $id)
                ->first();
            $name->priority = $priority;
            $name->save();
        }
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