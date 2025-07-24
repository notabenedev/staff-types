<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Notabenedev\StaffTypes\Facades\StaffParamActions;

class StaffParam extends Model
{
    use HasFactory;

    protected $fillable = [
        "value",
        "set_id"
    ];

    protected static function booting() {

        parent::booting();
    }

    /**
     * @return mixed
     */
    public function type(){
        return $this->unit->type;
    }

    /**
     * @return mixed
     */
    public function unit() {
        return $this->name->unit;
    }

    /**
     * Имя параметра
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function name(){
        return
            $this->belongsTo(\App\StaffParamName::class,"staff_param_name_id");
    }

    /**
     * Параметр может относиться к разным моделям (Сотруднику, Предложению)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */

    public function staffParamable() {
        return $this->morphTo();
    }


    /**
     * @return mixed|string
     */
    public function getSetHumanAttribute(){
            return isset($this->set_id) ? $this->set_id: 0;

    }
    /**
     * Найти модель по имени в конфиге.
     *
     * @param $modelName
     * @param $id
     * @return bool
     */
    public static function getParamsModel($modelName, $id)
    {
        $model = false;
        foreach (config('staff-types.staffParamModels') as $name => $class) {
            if (
                $name == $modelName &&
                class_exists($class)
            ) {
                try {
                    $model = $class::findOrFail($id);
                } catch (\Exception $e) {
                    return false;
                }
                break;
            }
        }
        return $model;
    }

    /**
     * @param $modelObject
     * @return array
     */
    public static function prepareParam($modelObject)
    {
        return StaffParamActions::getArray($modelObject);
    }


}
