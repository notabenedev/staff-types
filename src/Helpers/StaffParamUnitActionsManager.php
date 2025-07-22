<?php

namespace Notabenedev\StaffTypes\Helpers;

use App\StaffDepartment;
use App\StaffEmployee;
use App\StaffParamUnit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
     */
    protected function setItemsWeight(array $items)
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
     * @param bool $isNamePage
     * @return array
     *
     */
    public function getAdminBreadcrumb(StaffParamUnit $unit, $isNamePage = false)
    {

        $breadcrumb[] = (object) [
                "title" => config("staff-types.siteStaffParamUnitsName"),
                "url" => route("admin.staff-param-units.index"),
                "active" => false,
            ];

        $routeParams = Route::current()->parameters();
        $isNamePage = $isNamePage && ! empty($routeParams["name"]);
        $active = ! empty($routeParams["unit"]) &&
            $routeParams["unit"]->id == $unit->id &&
            ! $isNamePage;
        $breadcrumb[] = (object) [
            "title" => $unit->title,
            "url" => route("admin.staff-param-units.show", ["unit" => $unit]),
            "active" => $active,
        ];
        if ($isNamePage) {
            $name = $routeParams["name"];
            $breadcrumb[] = (object) [
                "title" => $name->title,
                "url" => route("admin.staff-param-names.show", ["name" => $name]),
                "active" => true,
            ];
        }

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

    /**
     * @param StaffParamUnit $unit
     * @param $newClass
     * @return bool
     */

    public function canChangeClass(StaffParamUnit $unit, $newClass)
    {
        $class = config("staff-types.staffParamModels")[$unit->getOriginal('class')];
        if (class_exists($class) && $unit->getOriginal('class') !== $newClass) {
            $value = $unit->names()->leftJoin('staff_params', 'staff_param_names.id', '=', 'staff_params.staff_param_name_id')
                ->where('staff_params.paramable_type', '=', $class)->first();
            if ($value)
                return false;
        }
        return true;
    }

    /**
     * @param StaffParamUnit $unit
     * @param $userInput
     * @return array|bool
     *
     */
    public function diffChangeTypes(StaffParamUnit $unit, $userInput){
        $typeIds = [];
        foreach ($userInput as $key => $value) {
            if (str_contains($key, "check-")) {
                $typeIds[$key] = $value;
            }
        }

        $types = $unit->types;
        $typeCurrentIds = [];
        foreach ($types as $type){
            $typeCurrentIds['check-'.$type->id] = 1;
        }

        if (count($typeIds)<1)
            $diff = $typeCurrentIds;
        else
            $diff = array_diff($typeCurrentIds, $typeIds);

        if (!count($diff)) return true;

        $departments = StaffDepartment::query()->select('id')->whereIn('staff_type_id', $diff)->get();
        $employees = StaffEmployee::query()->join('staff_department_staff_employee','staff_employees.id','staff_department_staff_employee.staff_employee_id')->whereIn('staff_department_id',$departments->toArray())->get();

        foreach ($employees as $employee){
            if ($employee->params){
                return $diff;
            }
            foreach ($employee->offers as $offer){
                if ($offer->params){
                    return $diff;
                }
            }
        }
        return true;
    }
}