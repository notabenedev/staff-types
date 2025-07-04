<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;

class StaffOffer extends Model
{
    use HasFactory;
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "priority",
        "price",
        "from_price",
        "old_price",
        "currency",
        "sales_notes",
        "description",
        "experience",
        "city",
    ];

    protected static function booting() {

        parent::booting();
    }

    /**
     * Адрес Предложения
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(\App\Contact::class);
    }

    /**
     * Сотрудник Предложения
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employee(){
        return $this->belongsToMany(\App\StaffEmployee::class,"staff_employee_id");
    }


}
