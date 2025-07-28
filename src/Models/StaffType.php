<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Notabenedev\StaffTypes\Helpers\StaffParamActionsManager;
use PortedCheese\BaseSettings\Traits\ShouldSlug;

class StaffType extends Model
{
    use HasFactory;
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "exported_at",
    ];

    protected static function booting() {

        parent::booting();
        self::deleting(function(\App\StaffType $model){
            $model->units()->sync([]);
            foreach ($model->offers as $offer){
                $offer->delete();
            }

            foreach ($model->departments as $department){
                $department->type()->dissociate();
                $department->save();
            }
        });

        self::created(function(\App\StaffType $model){
            $model->paramsClearCache();
        });
        self::deleted(function(\App\StaffType $model){
            $model->paramsClearCache();
        });
        self::updated(function(\App\StaffType $model){
            $model->paramsClearCache();
        });
    }
    protected  function paramsClearCache(){
        if ($this->offers)
        foreach ($this->offers as $offer){
            StaffParamActionsManager::availableClearCache($offer);
        }
        if ($this->departments)
            foreach ($this->departments as $department){
                if ($department->employees)
                    foreach ($department->employees as $employee) {
                        StaffParamActionsManager::availableClearCache($employee);
            }
        }
    }

    /**
     * Предложения
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers(){
        return $this->hasMany(\App\StaffOffer::class);
    }

    /**
     * Отделы (специализации) для набора параметров
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany(\App\StaffDepartment::class);
    }

    /**
     * Наборы параметров для Типа сотрудников
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function units(){
        return $this->belongsToMany(\App\StaffParamUnit::class,"staff_type_staff_param_unit")->orderBy('priority')
            ->withTimestamps();;
    }

    /**
     * Change exported status
     *
     */
    public function exported()
    {
        $this->exported_at = $this->exported_at  ? null : now();
        $this->save();
    }
    /**
     * Есть ли отдел
     *
     * @param $id
     * @return mixed
     */

    public function hasDepartment($id)
    {
        return $this->departments->where('id',$id)->count();
    }

}
