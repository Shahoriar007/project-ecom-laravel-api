<?php

namespace App\Traits;

trait UpdatedBy
{
    public static function bootUpdatedBy()
    {

        static::updating(function ($model) {
            $model->updated_by = auth()->user()->id ?? null;
        });
    }
}
