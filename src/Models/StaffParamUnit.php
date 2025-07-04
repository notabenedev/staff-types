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
        "priority",
        "demonstrated_at",
    ];

    protected static function booting() {

        parent::booting();
    }

    /**
     * Имена параметров группы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function names()
    {
        return $this->hasMany(\App\StaffParamName::class);
    }

    /**
     * Соотношение набора параметров с Типами сотрудников
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     */
    public function types(){
        return $this->belongsToMany(\App\StaffType::class,"staff_type_staff_param_unit")
            ->orderBy("priority")
            ->withTimestamps();;
    }


}
