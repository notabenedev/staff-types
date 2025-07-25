<?php

namespace Notabenedev\StaffTypes\Helpers;

use App\StaffEmployee;
use App\StaffOffer;
use App\StaffParamUnit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StaffParamActionsManager
{
    public static  function getArray($model)
    {
        $modelName = "";
        foreach (config('staff-types.staffParamModels') as $name => $class) {
            if (get_class($model) == $class) {
                $modelName = $name;
                break;
            }
        }
        $collection = $model->params->sortBy('id');
        $array = [];
        foreach ($collection as $item){
            $array[$item->id]=[
                'id' => $item->id,
                'name' => $item->name,
                'name_id' => $item->staff_param_name_id,
                'value' => $item->value,
                'set_id' => $item->setHuman,
                'valueChanged' => $item->value,
                'valueInput' => false,
                "valueUrl" => route("admin.vue.staff-params.value", [
                    "model" => $modelName,
                    'id' => $item->paramable_id,
                    'param' => $item->id,
                ]),

                'delete' => route('admin.vue.staff-params.delete', [
                    'model' => $modelName,
                    'id' => $item->paramable_id,
                    'param' => $item->id,
                ]),
            ];
        }

        return $array;
    }

    /**
     *
     * @param StaffOffer|StaffEmployee $modelObject
     * @return array
     */
    public static function prepareAvailableData($modelObject){
        $modelClass = get_class($modelObject);
        $unitClass = array_search($modelClass,config("staff-types.staffParamModels",[]));
        return Cache::remember('staff-param-available-data'.$modelClass.':'.$modelObject->id,8600,function () use ($modelObject,  $modelClass, $unitClass){
            if ($unitClass === "staff-offer" && isset($modelObject->employee))
            {
                $availableTypes[$modelObject->type->id] = $modelObject->type;
            }
            else
            {
                $employee = $modelObject;
                $departments = $employee->departments()->with('type')->get();
                $employeeTypes = [];
                foreach ($departments as $department){
                    if (isset($department->type))
                        $employeeTypes[$department->type->id] = $department->type;
                }
                $units = StaffParamUnit::query()->where("class",'=',$unitClass)->orderBy('priority')->get();
                $availableTypes = [];
                $availableTypes[0]=(object) ['title' => $employee->title, 'units' => $units, 'allowedArray' => array_keys($employeeTypes)];
            }
            $available = [];
            foreach ($availableTypes as $id => $type){
                $units = $type->units;
                // группы внутри типа
                foreach ($units as $unit){
                    if (isset($type->alllowedArray) && ! in_array($unit->type->id, $type->alllowedArray)) continue;
                    $names  = $unit->names;
                    if ( $unit->class === $unitClass){
                        $namesArray = [];
                        $setsArray = [];
                        $countSets = 0;

                        // имена внутри типа
                        foreach ($names as $name){
                            $valuesArray = [];
                            $setsValuesArray[$name->id] = [];
                            $values = $modelObject->params()->where('staff_param_name_id','=', $name->id)->orderBy('set_id')->get();

                            // значения и сеты имен
                            foreach ($values as $value){
                                $valuesArray[$value->staff_param_name_id][$value->setHuman] =  ["id"=>$value->id, "value"=> $value->value];
                                $setsValuesArray[$value->staff_param_name_id][] = $value->setHuman;
                            }

                            $currentCountSets = count($setsValuesArray[$name->id]);
                            if ($currentCountSets >= $countSets){
                                $setsArray = $setsValuesArray[$name->id];
                                $countSets = $currentCountSets;
                            }

                            // добавляем значения к элементу Имя
                            $emptyValue[$name->id][0]= '';
                            $valuesToMerge = isset($valuesArray[$name->id]) ? $valuesArray[$name->id]:$emptyValue;
                            $el = $name->toArray() ;
                            $el["values"] = $valuesToMerge;
                            $namesArray[] = $el;
                        }
                        $available[$type->title][] = ["id" => $unit->id, "title" => $unit->title, "demonstrated" => $unit->demonstrated_at? 1:0, "names"=> $namesArray, 'sets' => $setsArray];
                    }

                }
            }
            return $available;
        });

    }

    /**
     * @param $modelObject
     * @return void
     */
    public static function availableClearCache($modelObject){

        $modelClass = get_class($modelObject);
        Log::info($modelClass);
        Cache::forget('staff-param-available-data'.$modelClass.':'.$modelObject->id);
    }

    /**
     * @return void
     */
    public static function availableClearCacheAll(){
        Log::info('all');
        $employees = StaffEmployee::all();
        foreach ($employees as $employee)
        {
            StaffParamActionsManager::availableClearCache($employee);
        }
        $offers = StaffOffer::all();
        foreach ($offers as $offer)
        {
            StaffParamActionsManager::availableClearCache($offer);
        }
    }
}