<?php

namespace Joselfonseca\LaravelApiTools\Traits;

use Uuid;

/**
 * Class UuidScopeTrait
 * @package Joselfonseca\LaravelApiTools\Traits
 */
trait UuidScopeTrait
{

    /**
     * @param $query
     * @param $uuid
     * @return mixed
     */
    public function scopeByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }
}
