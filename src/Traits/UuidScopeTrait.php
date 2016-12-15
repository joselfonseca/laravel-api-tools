<?php

namespace Joselfonseca\LaravelApiTools\Traits;

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
}
