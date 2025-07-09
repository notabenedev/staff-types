<?php

namespace Notabenedev\StaffTypes\Helpers;

use App\StaffParamUnit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class StaffParamUnitActionsManager
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
     * @param int $parent
     */
    protected function setItemsWeight(array $items, int $parent)
    {
        foreach ($items as $priority => $item) {
            $id = $item["id"];
            // Обновление
            $unit = StaffParamUnit::query()
                ->where("id", $id)
                ->first();
            $unit->priority = $priority;
            $unit->save();
        }
    }


    /**
     * Получить данные в массив
     *
     * @return array
     */
    protected function makeArrayData()
    {
        $units = DB::table("staff_param_units")
            ->select("id", "title", "slug", "priority")
            ->orderBy("priority")
            ->get();

        $array = [];
        foreach ($units as $item) {
            $array[] = [
                "title" => $item->title,
                'slug' => $item->slug,
                "priority" => $item->priority,
                "id" => $item->id,
                "url" => route("admin.staff-param-units.show", ['unit' => $item->slug]),
                "siteUrl" => route("site.staff-param-units.show", ["unit" => $item->slug]),
            ];
        }
        return $array;
    }

    /**
     * Admin breadcrumbs
     *
     * @param StaffParamUnit $unit
     * @return array
     *
     */
    public function getAdminBreadcrumb(StaffParamUnit $unit)
    {

        $breadcrumb[] = (object) [
                "title" => config("staff-types.siteStaffParamUnitsName"),
                "url" => route("admin.staff-param-units.index"),
                "active" => false,
            ];

        $routeParams = Route::current()->parameters();
        $active = ! empty($routeParams["unit"]) &&
            $routeParams["unit"]->id == $unit->id;
        $breadcrumb[] = (object) [
            "title" => $unit->title,
            "url" => route("admin.staff-param-units.show", ["unit" => $unit]),
            "active" => $active,
        ];

        return $breadcrumb;
    }


    /**
     * Получить имена параметров группы
     *
     * @param int $unitId
     * @return mixed
     */
    public function getParamUnitParamNamesIds($unitId)
    {
        $unit = StaffParamUnit::query()->where("id","=",$unitId)->first();
        $key = "staff-param-unit-actions-getParamUnitParamNames:{$unit->id}";
        return Cache::rememberForever($key, function() use ($unit) {
            $names = $unit->names;
            $items = [];
            foreach ($names as $key => $item) {
                $items[$item->id] = $item;
            }
            return $items;
        });
    }

    /**
     * Очистить кэш идентификаторов параметров группы.
     *
     * @param StaffParamUnit $unit
     */
    public function forgetParamUnitParamNamesIds(StaffParamUnit $unit)
    {
        $keys = ["staff-param-unit-actions-getParamUnitParamNames:{$unit->id}"];
        foreach ($keys as $key){
            Cache::forget("$key");
        }
    }
}