<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Adds scopes to model for active/inactive filtering.
 * is_active column must be present on the DB table.
 */
trait QueryActive
{
    /**
     * Returns only active records.
     */
    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    /**
     * Returns only inactive records.
     */
    public function scopeOnlyInActive(Builder $query): Builder
    {
        return $query->where('is_active', 0);
    }
}
