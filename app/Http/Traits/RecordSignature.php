<?php

namespace App\Http\Traits;

trait RecordSignature
{
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->updated_by =  auth()->user()->id;
        });

        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->user()->id;
        });
    }
}