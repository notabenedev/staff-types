<?php

namespace Notabenedev\StaffTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\ShouldSlug;

class StaffOffer extends Model
{
    use HasFactory;
    use ShouldSlug;

    const SALES_NOTES_VARIANTS = [
        "first" => "Первичный приём",
        "undefined" => "Цена неизвестна",
    ];
    const CURRENCY_VARIANTS = [
        "RUR" => "руб",
    ];

    protected $fillable = [
        "title",
        "slug",
        "price",
        "from_price",
        "old_price",
        "currency",
        "sales_notes",
        "description",
        "experience",
        "city",
        "published_at",
        "priority",
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
     *  Сотрудник Предложения
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(){
        return $this->belongsTo(\App\StaffEmployee::class,"staff_employee_id");
    }

    /**
     * Change published status
     *
     */
    public function published()
    {
        $this->published_at = $this->published_at  ? null : now();
        $this->save();
    }

    /**
     * Валюта
     *
     * @return string|void
     */
    public function getCurrencyHumanAttribute(){
        if (! empty($this->currency))
            return $this::CURRENCY_VARIANTS[$this->currency];
    }

    /**
     * Адрес работы
     *
     * @return mixed
     */
    public function getAddressAttribute(){
        return empty($this->contact->address) ? $this->contact->title : $this->contact->address;
    }


}
