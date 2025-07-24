<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;

class StaffParamUnit extends Model
{
    use HasFactory;
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "class",
        "priority",
        "demonstrated_at",
    ];

    protected static function booting() {

        parent::booting();
        self::deleting(function(\App\StaffParamUnit $model){
            $model->types()->sync([]);
            foreach ($model->names as $name){
                $name->delete();
            }
        });
    }

    /**
     * Имена параметров группы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function names()
    {
        return $this->hasMany(\App\StaffParamName::class)->orderBy('priority');
    }

    /**
     * Соотношение набора параметров с Типами сотрудников
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     */
    public function types(){
        return $this->belongsToMany(\App\StaffType::class,"staff_type_staff_param_unit")
            ->withTimestamps();
    }

    /**
     * Change demonstrated status
     *
     */
    public function demonstrated()
    {
        $this->demonstrated_at = $this->demonstrated_at  ? null : now();
        $this->save();
    }

    /**
     * Есть ли Тип у группы параметров
     *
     * @param $id
     * @return mixed
     */

    public function hasType($id)
    {
        return $this->types->where('id',$id)->count();
    }

    /**
     * Обновить типы.
     *
     * @param $userInput
     */
    public function updateTypes($userInput)
    {
        $typeIds = [];
        foreach ($userInput as $key => $value) {
            if (strstr($key, "check-") == false) {
                continue;
            }
            $typeIds[] = $value;
        }
        $this->types()->sync($typeIds);
        //$this->forgetCache();
    }


}
