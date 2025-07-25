<?php

namespace Notabenedev\StaffTypes\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\StaffParam;
use App\StaffParamName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Notabenedev\StaffTypes\Events\ParamUpdate;
use Notabenedev\StaffTypes\Facades\StaffParamActions;
use Notabenedev\StaffTypes\Helpers\StaffParamActionsManager;
use Notabenedev\StaffTypes\Http\Requests\StaffParamPostRequest;

class StaffParamController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(StaffParam::class, "staff-params");
    }


    /**
     * @param $model
     * @param $id
     * @return array
     */
    public function available($model, $id){
        $modelObject = StaffParam::getParamsModel($model, $id);
        if ($modelObject) {
            return [
                'success' => TRUE,
                'available' => StaffParamActions::prepareAvailableData($modelObject),
            ];
        }
        else {
            return [
                'success' => FALSE,
                'message' => 'Model not found',
            ];
        }
    }
    /**
     * Получаем все параметры модели.
     * @param $model
     * @param $id
     * @return array
     */
    public function get($model, $id) {
        $modelObject = StaffParam::getParamsModel($model, $id);
        if ($modelObject) {
            return [
                'success' => TRUE,
                'params' => StaffParamActions::getArray($modelObject),
                'available' =>
                    StaffParamActions::prepareAvailableData($modelObject),
            ];
        }
        else {
            return [
                'success' => FALSE,
                'message' => 'Model not found',
            ];
        }
    }

    /**
     * Пробуем сохранить параметр.
     *
     * @param Request $request
     * @param $model
     * @param $id
     * @return array
     */
    public function post(StaffParamPostRequest $request, $model, $id) {
        $modelClass = StaffParam::getParamsModel($model, $id);
        if (! $modelClass) {
            return [
                'success' => FALSE,
                'message' => 'Model not found',
            ];
        }

        $name = StaffParamName::query()->where('id','=', intval($request->get("staff_param_name_id")))->first();
        if ($name){
            $param = $name->params()->create([
                'value' => $request->get("value"),
                'set_id' => $request->get("set_id")? $request->get("set_id"):0,
            ]);
            $modelClass->params()->save($param);
            event(new ParamUpdate($param, "created"));
            StaffParamActionsManager::availableClearCache($modelClass);
            return [
                'success' => TRUE,
                'param' => $param->toArray(),
                'available' =>
                    StaffParamActions::prepareAvailableData($modelClass),
                'params' =>
                    StaffParam::prepareParam($modelClass),
            ];
        }
        else
            return [
                'success' => FALSE,
                'message' => 'Name not found',
            ];

    }

    /**
     * Пробуем удалить параметр.
     *
     * @param $model
     * @param $id
     * @param $param
     * @return array
     */
    public function delete($model, $id, $param) {
        if ($modelClass = StaffParam::getParamsModel($model, $id)) {
            try {
                $paramObject = StaffParam::findOrFail($param);
            } catch (\Exception $e) {
                return [
                    'success' => FALSE,
                    'message' => 'Param not found',
                ];
            }
            $paramObject->delete();
            StaffParamActionsManager::availableClearCache($modelClass);
            return [
                'success' => TRUE,
                'params' => StaffParam::prepareParam($modelClass),
                'available' =>
                    StaffParamActions::prepareAvailableData($modelClass),
            ];
        }
        else {
            return [
                'success' => FALSE,
                'message' => 'Model not found',
            ];
        }
    }

    /**
     * Изменить значение.
     *
     * @param Request $request
     * @param $model
     * @param $id
     * @param $param
     * @return array
     */
    public function value(Request $request, $model, $id, $param)
    {
        if (! $request->has("changed")) {
            return [
                'success' => FALSE,
                'message' => "Не найден",
            ];
        }
        if (!$modelClass = StaffParam::getParamsModel($model, $id)) {
            return [
                'success' => FALSE,
                'message' => 'Model not found',
            ];
        }
        try {
            $paramObject = StaffParam::query()
                ->where("id", $param)
                ->firstOrFail();
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'message' => 'Param not found',
            ];
        }
        if (empty($request->get('changed'))) {
            $paramObject->delete();
        }
        else {
            $paramObject->value = $request->get('changed');
            $paramObject->save();
            event(new ParamUpdate($paramObject, "updated"));

        }
        StaffParamActionsManager::availableClearCache($modelClass);

        return [
            'success' => TRUE,
            'params' => StaffParam::prepareParam($modelClass),
            'available' =>
                StaffParamActions::prepareAvailableData($modelClass),
        ];
    }
}
