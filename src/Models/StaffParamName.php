<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;

class StaffParamName extends Model
{
    use HasFactory;
    use ShouldSlug;

    const ALLOW_TYPES = [
        "string" => "Строка",
        "int" => "Число",
        "bool" => "Логическое",
    ];
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

    /**
     * Human value type
     *
     * @return string
     */

    public function getValueTypeHumanAttribute(){
        return $this::ALLOW_TYPES[$this->value_type];
    }

    /**
     * Change expected status
     *
     */
    public function expected()
    {
        $this->expected_at = $this->expected_at  ? null : now();
        $this->save();
    }

}
