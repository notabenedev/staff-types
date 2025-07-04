<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    }

    /**
     * Отделы (специализации)
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
        return $this->belongsToMany(\App\StaffParamUnit::class,"staff_type_staff_param_unit")
            ->withTimestamps();;
    }

    /**
     * Change publish status
     *
     */
    public function exported()
    {
        $this->exported_at = $this->exported_at  ? null : now();
        $this->save();
    }


}
