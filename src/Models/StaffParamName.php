<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;

class StaffParamName extends Model
{
    use HasFactory;
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "name",
        "value_type",
        "priority",
        "expected_at",
    ];

    protected static function booting() {

        parent::booting();
    }

    /**
     * Группа параметра
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function unit(){
        return $this->belongsTo(\App\StaffParamUnit::class,"staff_param_unit_id")->withDefault(null);
    }




}
