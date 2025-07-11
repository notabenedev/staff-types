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
            $name = StaffOffer::query()
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