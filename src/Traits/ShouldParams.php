<?php

namespace Notabenedev\StaffTypes\Traits;

use App\StaffParam;


trait ShouldParams
{
    protected static function bootShouldParams()
    {
        static::deleting(function($model) {
            // Чистим параметры.
            $model->clearParams();
        });
    }

    /**
     * Параметры.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function params() {
        return $this->morphMany(StaffParam::class, 'paramable');
    }


    /**
     * Удалить все параметры.
     */
    public function clearParams()
    {
        foreach ($this->params() as $param) {
            $param->delete();
        }
    }

}