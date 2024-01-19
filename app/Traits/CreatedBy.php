<?php

namespace App\Traits;

trait CreatedBy
{
    public static function bootCreatedBy()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id ?? null;
        });
    }
}
